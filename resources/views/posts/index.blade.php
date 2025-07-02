<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $champion->name }} の投稿一覧
            </h2>
            
            {{-- 新規投稿作成ボタン --}}
            <a href="/posts/create/{{ $champion->id }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                新規投稿を作成
            </a>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if($posts->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-lg text-gray-500">このチャンピオンに関する投稿はまだありません。</p>
                            <p class="text-sm text-gray-400 mt-2">最初の投稿をしてみましょう！</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('posts.show', $post) }}">
                                                <h3 class="text-xl font-bold text-gray-900 hover:text-blue-600 transition-colors">
                                                    {{ $post->title }}
                                                </h3>
                                            </a>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                                <span>
                                                    <strong>レーン:</strong> {{ $post->lane->name ?? '未設定' }}
                                                </span>
                                                <span>
                                                    <strong>投稿者:</strong> {{ $post->user->name ?? '匿名' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right text-sm text-gray-500">
                                            <span>{{ $post->created_at->format('Y/m/d') }}</span>
                                        </div>
                                    </div>
                                    
                                    <p class="mt-4 text-gray-700 leading-relaxed">
                                        {{ Str::limit($post->content, 150) }}
                                    </p>
                                    
                                    <div class="text-right mt-4">
                                        <a href="{{ route('posts.show', $post) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                            続きを読む &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- ページネーション --}}
                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>