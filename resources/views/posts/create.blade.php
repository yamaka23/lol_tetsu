<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規投稿作成 - {{ $champion->name }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <input type="hidden" name="post[champion_id]" value="{{ $champion->id }}">

            {{-- タイトル --}}
            <div class="mb-6">
                <label class="block font-bold mb-2">タイトル</label>
                <input type="text" name="post[title]" class="w-full border rounded px-3 py-2" placeholder="タイトル">
            </div>

            {{-- レーン --}}
            <div class="mb-6">
                <label class="block font-bold mb-2">レーン</label>
                <select name="post[lane_id]" class="w-full border rounded px-3 py-2">
                    @foreach($lanes as $lane)
                        <option value="{{ $lane->id }}">{{ $lane->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 本文 --}}
            <div class="mb-6">
                <label class="block font-bold mb-2">本文</label>
                <textarea name="post[content]" rows="5" class="w-full border rounded px-3 py-2" placeholder="内容を書いてください"></textarea>
            </div>

            {{-- ルーン --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- メインパス --}}
                <div class="border rounded p-4 bg-white">
                    <h3 class="font-bold mb-4 text-red-600">メインパス</h3>
                    <div class="flex gap-3 mb-4">
                        @foreach ($mainRunes as $path)
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="main_path" value="{{ $path->id }}" class="hidden main-path-radio">
                                <img src="https://ddragon.leagueoflegends.com/cdn/img/{{ $path->icon }}" 
                                     class="w-12 h-12  rounded-full border-2 border-gray-300 hover:border-yellow-400 main-path-img">
                                <span class="mt-1 text-sm">{{ $path->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- ルーンのスロット --}}
                    @foreach ($mainRunes as $path)
                        <div class="main-rune-group hidden " data-path-id="{{ $path->id }}">
                            <h4 class="font-semibold">{{ $path->name }}</h4>
                            @php
                                $runesBySlot = $path->runes->groupBy('slot_index');
                            @endphp
                            @foreach ($runesBySlot as $slotIndex => $runesInSlot)
                                <div class="flex gap-2 mb-2">
                                    @foreach ($runesInSlot as $rune)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="main_runes[{{ $slotIndex }}]" value="{{ $rune->id }}" class="hidden peer">
                                            <img src="https://ddragon.leagueoflegends.com/cdn/img/{{ $rune->icon }}" 
                                                 class="w-12 h-12 rounded-full border-2 border-gray-300 peer-checked:border-yellow-400" 
                                                 alt="{{ $rune->name }}">
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                {{-- サブパス --}}
                <div class="border rounded p-4 bg-white">
                    <h3 class="font-bold mb-4 text-blue-600">サブパス</h3>
                    <div class="flex gap-3 mb-4">
                        @foreach ($mainRunes as $path)
                            <label class="flex flex-col items-center cursor-pointer sub-path-label" data-path-id="{{ $path->id }}">
                                <input type="checkbox" name="sub_runes[]" value="{{ $path->id }}" class="hidden sub-path-radio">
                                <img src="https://ddragon.leagueoflegends.com/cdn/img/{{ $path->icon }}" 
                                     class="w-12 h-12 rounded-full border-2 border-gray-300 hover:border-blue-400 sub-path-img">
                                <span class="mt-1 text-sm">{{ $path->name }}</span>
                            </label>
                        @endforeach
                    </div>


                {{-- ルーンのスロット --}}
                    @foreach ($mainRunes as $path)
                        <div class="sub-rune-group hidden" data-path-id="{{ $path->id }}">
                            <h4 class="font-semibold">{{ $path->name }}</h4>
                            @php
                                $runesBySlot = $path->runes->groupBy('slot_index');
                            @endphp
                            @foreach ($runesBySlot as $slotIndex => $runesInSlot)
                            @if($slotIndex !== 0)
                                <div class="flex gap-2 mb-2">
                                    @foreach ($runesInSlot as $rune)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="sub_runes[{{ $slotIndex }}]" value="{{ $rune->id }}" class="hidden peer">
                                            <img src="https://ddragon.leagueoflegends.com/cdn/img/{{ $rune->icon }}" 
                                                 class="w-12 h-12 rounded-full border-2 border-gray-300 peer-checked:border-yellow-400" 
                                                 alt="{{ $rune->name }}">
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

                {{-- ステータス --}}
                <div class="border rounded p-4 bg-white">
                    <h3 class="font-bold mb-4 text-green-600">ステータス</h3>
                    <div class="space-y-4">
                        @foreach (['攻撃速度', 'アダプティブ', '物理防御', '魔法防御', '体力'] as $status)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="statuses[]" value="{{ $status }}" class="peer hidden">
                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center peer-checked:ring-2 ring-blue-400">
                                    {{ Str::substr($status, 0, 1) }}
                                </div>
                                <span>{{ $status }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- アイテム --}}
            <div class="mb-8">
                <h3 class="font-bold mb-2">おすすめアイテム</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($items as $item)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="post[item_ids][]" value="{{ $item->id }}" class="hidden peer">
                            <img src="https://ddragon.leagueoflegends.com/cdn/{{ $item->version }}/img/item/{{ $item->image }}" 
                                 class="w-12 h-12 rounded border-2 border-gray-300 peer-checked:border-green-400" 
                                 alt="{{ $item->name }}">
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- ボタン --}}
            <div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    投稿する
                </button>
            </div>
        </form>
    </div>

    {{-- スクリプト --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- ユーティリティ関数 ---
        // 指定されたコンテナ内の選択状態を可視化する関数
        function updateVisuals(container) {
            if (!container) return; // コンテナがなければ何もしない
            const labels = container.querySelectorAll('label');
            labels.forEach(label => {
                const input = label.querySelector('input');
                // inputが存在し、チェックされていれば不透明に、そうでなければ半透明にする
                if (input && input.checked) {
                    label.classList.remove('opacity-50');
                } else {
                    label.classList.add('opacity-50');
                }
            });
        }

        // --- 1. メインパス選択のロジック ---
        const mainRadios = document.querySelectorAll('.main-path-radio');
        const mainRuneGroups = document.querySelectorAll('.main-rune-group');
        const subLabels = document.querySelectorAll('.sub-path-label');

        mainRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                const selectedMainPathId = this.value;

                // a. メインパスのルーン群の表示/非表示
                mainRuneGroups.forEach(group => {
                    group.classList.toggle('hidden', group.dataset.pathId !== selectedMainPathId);
                });

                // b. サブパスの選択肢から、選んだメインパスを無効化
                subLabels.forEach(label => {
                    const subRadio = label.querySelector('.sub-path-radio');
                    if (label.dataset.pathId === selectedMainPathId) {
                        label.classList.add('opacity-50', 'pointer-events-none');
                        if (subRadio.checked) {
                            subRadio.checked = false;
                            // 表示されていたサブルーンを隠す
                            document.querySelectorAll('.sub-rune-group').forEach(g => g.classList.add('hidden'));
                        }
                    } else {
                        label.classList.remove('opacity-50', 'pointer-events-none');
                    }
                });
            });
        });

        // --- 2. サブパス選択のロジック ---
        const subRadios = document.querySelectorAll('.sub-path-radio');
        const subRuneGroups = document.querySelectorAll('.sub-rune-group');
        subRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                const selectedSubPathId = this.value;
                subRuneGroups.forEach(group => {
                    group.classList.toggle('hidden', group.dataset.pathId !== selectedSubPathId);
                });
            });
        });

        // --- 3. ルーン選択の可視化とルール適用 ---
        // a) メインパスのルーン（ラジオボタン）
        document.querySelectorAll('.main-rune-group .slot-row').forEach(slot => {
            slot.addEventListener('change', () => updateVisuals(slot));
        });

        // b) サブパスのルーン（チェックボックス）
        const subRuneCheckboxes = document.querySelectorAll('.sub-rune-checkbox');
        subRuneCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                const container = e.target.closest('.sub-rune-group');
                const checkedSubRunes = container.querySelectorAll('.sub-rune-checkbox:checked');
                const selectedSubSlots = new Set();
                checkedSubRunes.forEach(cb => selectedSubSlots.add(cb.dataset.slotIndex));

                // 2つ以上、または同じスロットから2つ選ぼうとしたら選択をキャンセル
                if (checkedSubRunes.length > 2 || selectedSubSlots.size < checkedSubRunes.length) {
                    alert('サブパスからは、異なるスロットのルーンを2つまで選択できます。');
                    e.target.checked = false;
                }
                
                // 【修正点】サブルーンの選択が変更された後、見た目を更新する
                updateVisuals(container);
            });
        });

        // c) ステータスシャード（ラジオボタン）
        document.querySelectorAll('.shard-row').forEach(slot => {
            slot.addEventListener('change', () => updateVisuals(slot));
        });
        
        // --- 【改善点】ページ読み込み時に、全てのルーンの見た目を初期化 ---
        document.querySelectorAll('.main-rune-group .slot-row, .sub-rune-group, .shard-row').forEach(container => {
            updateVisuals(container);
        });
    });
    </script>

</x-app-layout>
