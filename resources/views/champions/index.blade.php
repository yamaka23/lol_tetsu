<x-app-layout>
<x-slot name="header">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャンピオン一覧 ({{ $version }})</title>
    <style>
        body { font-family: sans-serif; }
        .champion { border: 1px solid #ccc; margin: 10px; padding: 10px; width: 200px; float: left; }
        .champion img { max-width: 100%; }
        .clearfix::after { content: ""; clear: both; display: table; }
        .nav-link { margin-bottom: 20px; display: block; }
    </style>
</x-slot>
(各ブレードファイルの中身)

<html lang="ja">
<body>
    <h1>チャンピオン一覧 (バージョン: {{ $version }})</h1>
    
    <a href="{{ route('posts.index') }}" class="nav-link">投稿一覧ページ</a>

    <div class="clearfix">
        @if(!empty($champions))
            @foreach($champions as $championKey => $champion)
                <div class="champion">
                    <h2>{{ $champion['name'] }} ({{ $championKey }})</h2>
                    <p>{{ $champion['title'] }}</p>
                    @if(isset($champion['image']['full']))
                        {{-- 画像をクリックしたら投稿一覧ページ（/posts）に飛ぶ --}}

                        <a href="/posts/{{ $championKey }}">
                            <img 
                                src="https://ddragon.leagueoflegends.com/cdn/{{ $version }}/img/champion/{{ $champion['image']['full'] }}" 
                                alt="{{ $champion['name'] }}"
                            >
                        </a>
                    @endif
                </div>
            @endforeach
        @else
            <p>チャンピオンデータが見つかりませんでした。</p>
        @endif
    </div>
</body>
</x-app-layout>






