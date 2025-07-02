<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function syncItems()
    {
        $language = 'ja_JP';

        // 最新バージョンを取得
        $versionsResponse = Http::withoutVerifying()->get('https://ddragon.leagueoflegends.com/api/versions.json');
        $versionsResponse->throw();
        $latestVersion = $versionsResponse->json()[0] ?? null;
        if (!$latestVersion) {
            return response()->json(['error' => '最新バージョンの取得に失敗しました。'], 500);
        }

        // アイテムデータを取得
        $itemsDataUrl = "https://ddragon.leagueoflegends.com/cdn/{$latestVersion}/data/{$language}/item.json";
        $itemsResponse = Http::withoutVerifying()->get($itemsDataUrl);
        $itemsResponse->throw();
        $itemListData = $itemsResponse->json()['data'] ?? [];

        DB::beginTransaction();
        try {
            foreach ($itemListData as $itemApiId => $details) {
                Item::updateOrCreate(
                    [
                        'id' => $itemApiId,
                        'language' => $language,
                    ],
                    [
                        'name' => $details['name'],
                        'image' => $details['image']['full'] ?? null,
                        'stats' => $details['stats'] ?? [],
                        'description' => strip_tags($details['description'] ?? ''),
                        'gold' => $details['gold'] ?? [],
                        'tags' => $details['tags'] ?? [],
                        'version' => $latestVersion,
                        'is_into' => !empty($details['into']),
                        'inStore' => $details['inStore'] ?? true,
                        'requiredChampion' => $details['requiredChampion'] ?? null,
                        'maps' => collect($details['maps'] ?? [])
                            ->mapWithKeys(fn($v, $k) => [$k => filter_var($v, FILTER_VALIDATE_BOOLEAN)])
                            ->toArray(),
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to sync items.', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to sync items.', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Item sync completed.']);
    }

    public function listItems()
    {
        $language = 'ja_JP';
        $latestVersionEntry = Item::where('language', $language)
            ->orderBy('version', 'desc')
            ->first();

        if (!$latestVersionEntry) {
            return view('items.list', ['items' => collect(), 'message' => 'データがありません。']);
        }

        $items = Item::where('language', $language)
            ->where('version', $latestVersionEntry->version)
            ->orderBy('name')
            ->get();

        return view('items.list', [
            'items' => $items,
        ]);
    }
}
