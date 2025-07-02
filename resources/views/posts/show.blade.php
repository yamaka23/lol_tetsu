<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('投稿詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    {{-- 投稿タイトル --}}
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $post->title }}
                    </h1>

                    {{-- 投稿のメタ情報 --}}
                    <div class="flex items-center space-x-6 text-sm text-gray-500 my-4">
                        <div class="flex items-center">
                            @if($post->champion)
                                <img src="https://ddragon.leagueoflegends.com/cdn/{{ $post->champion->version }}/img/champion/{{ $post->champion->image }}" alt="{{$post->champion->name}}" class="h-6 w-6 rounded-full mr-2">
                                <strong>チャンピオン:</strong>&nbsp;{{ $post->champion->name }}
                            @endif
                        </div>
                        <div class="flex items-center">
                            <strong>レーン:</strong>&nbsp;{{ $post->lane->name ?? '未設定' }}
                        </div>
                        <div class="flex items-center">
                             <strong>投稿者:</strong>&nbsp;{{ $post->user->name ?? '匿名' }}
                        </div>
                        <div class="flex items-center">
                            <strong>投稿日:</strong>&nbsp;{{ $post->created_at->format('Y年m月d日') }}
                        </div>
                    </div>

                    <hr class="my-6">

                    {{-- 投稿内容 --}}
                    <div class="prose max-w-none text-gray-800 leading-relaxed">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    {{-- おすすめルーン --}}
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-3">おすすめルーン</h2>
                        @if($post->runes->isEmpty())
                            <p class="text-gray-500">選択されたルーンはありません。</p>
                        @else
                            <div class="flex flex-wrap gap-3">
                                @foreach($post->runes as $rune)
                                    <div class="icon-wrapper" data-tooltip-target="tooltip-rune-{{$rune->id}}">
                                        <img class="h-12 w-12 rounded-md border-2 border-gray-300" src="https://ddragon.leagueoflegends.com/cdn/img/{{ $rune->image }}" alt="{{ $rune->name }}">
                                    </div>
                                    <div id="tooltip-rune-{{$rune->id}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                        {{ $rune->shortDesc ?? $rune->name }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- おすすめアイテム --}}
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-3">おすすめアイテム</h2>
                        @if($post->items->isEmpty())
                            <p class="text-gray-500">選択されたアイテムはありません。</p>
                        @else
                            <div class="flex flex-wrap gap-3">
                                @foreach($post->items as $item)
                                    <div class="icon-wrapper" data-tooltip-target="tooltip-item-{{$item->id}}">
                                        <img class="h-12 w-12 rounded-md border-2 border-gray-300" src="https://ddragon.leagueoflegends.com/cdn/{{ $item->version }}/img/item/{{ $item->image }}" alt="{{ $item->name }}">
                                    </div>
                                    <div id="tooltip-item-{{$item->id}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                        {{ $item->name }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- 戻るボタン --}}
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900">
                            &larr; 一覧に戻る
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // FlowbiteのTooltipを初期化
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-tooltip-target]');
            tooltips.forEach(el => {
                const targetId = el.getAttribute('data-tooltip-target');
                const targetEl = document.getElementById(targetId);
                new Flowbite.Tooltip(targetEl, el, {
                    placement: 'top', // ツールチップを上に表示
                });
            });
        });
    </script>
    @endpush

</x-app-layout>