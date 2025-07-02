<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Http\Requests\PostRequest; // useする
use App\Models\Category;
use App\Models\Champion; // Championモデルをuseする
use App\Models\Lane;
use App\Models\Rune;
use App\Models\Item;
use App\Models\MainRune; // MainRuneモデルをuseする
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Champion $champion)
    {
        $posts = $champion->posts()->paginate(10);
        return view('posts.index')->with(['posts' => $posts]);
    }

    
    public function show(Post $post)
    {
        $post->load(['runes', 'items']);
        return view('posts.show')->with(['post' => $post]);
    }

    
    public function store(Post $post, Request $request)
    {
        $input = $request->input('post');
        

        $post->fill($input);
        $post->user_id = auth()->id() ?? 1; // 現在のユーザーIDを設定
        dd($post);
        $post->save();

        // ルーンの関連付け（多対多）
        if (!empty($input['rune_ids'])) {
            $post->runes()->sync($input['rune_ids']);
        }

        // アイテムの関連付け（多対多・順序あり）
        if (!empty($input['item_ids'])) {
            $itemData = [];
            foreach ($input['item_ids'] as $index => $itemId) {
                $itemData[$itemId] = ['order' => $index + 1]; // orderを保持
            }
            $post->items()->sync($itemData);
        }

        return redirect('/posts/' . $post->id);
    }
    

    public function create( Champion $champion)
    {
        $lanes = Lane::all();

        $main_runes =  MainRune::with(['runes' => function($query) {
            $query->orderBy('slot_index');
        }])->get(); // ルーンをメインルーンごとにグループ化
        $subRunes = $main_runes;

        $items = Item::general()->get();

        // ステータスボーナス（簡易データ）
        $statusOptions = [
            [
                ['id' => 'offense_adapt', 'name' => '攻撃力', 'icon' => '/img/status/adaptive.png'],
                ['id' => 'offense_as', 'name' => '攻撃速度', 'icon' => '/img/status/attack-speed.png'],
                ['id' => 'offense_cdr', 'name' => 'スキルヘイスト', 'icon' => '/img/status/haste.png'],
            ],
            [
                ['id' => 'flex_armor', 'name' => '物理防御', 'icon' => '/img/status/armor.png'],
                ['id' => 'flex_mr', 'name' => '魔法防御', 'icon' => '/img/status/magic-resist.png'],
                ['id' => 'flex_hp', 'name' => '体力', 'icon' => '/img/status/health.png'],
            ],
            [
                ['id' => 'defense_hp', 'name' => '体力', 'icon' => '/img/status/health.png'],
                ['id' => 'defense_armor', 'name' => '物理防御', 'icon' => '/img/status/armor.png'],
                ['id' => 'defense_mr', 'name' => '魔法防御', 'icon' => '/img/status/magic-resist.png'],
            ],
        ];


        return view('posts.create', [
            'champion' => $champion,
            'lanes' => $lanes,
            'mainRunes' => $main_runes,
            'subRunes' => $subRunes,
            'statusOptions' => $statusOptions,
            'items' => $items,
        ]);
    }

    public function listByChampion(Champion $champion)
    {
        $posts = Post::where('champion_id', $champion->id)
                    ->with([ 'lane'])
                    ->latest()
                    ->paginate(10);

        return view('posts.index', compact('champion', 'posts'));
    }


    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id);
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/posts');
    }
}
