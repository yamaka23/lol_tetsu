<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャンピオン一覧 ({{ $version }})</title>
    <style>
        body { font-family: sans-serif; }
        .champion { border: 1px solid #ccc; margin: 10px; padding: 10px; width: 200px; float: left; }
        .champion img { max-width: 100%; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <h1>チャンピオン一覧 (バージョン: {{ $version }})</h1>
    <div class="clearfix">
        @if(!empty($champions))
            @foreach($champions as $championKey => $champion)
                <div class="champion">
                    <h2>{{ $champion['name'] }} ({{ $championKey }})</h2>
                    <p>{{ $champion['title'] }}</p>
                    @if(isset($champion['image']['full']))
                        <img src="https://ddragon.leagueoflegends.com/cdn/{{ $version }}/img/champion/{{ $champion['image']['full'] }}" alt="{{ $champion['name'] }}">
                    @endif
                </div>
            @endforeach
        @else
            <p>チャンピオンデータが見つかりませんでした。</p>
        @endif
    </div>
</body>
</html>






