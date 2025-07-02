<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ルーン一覧</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #1e3a5f;
        }
        .runes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 15px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .rune-icon-wrapper {
            position: relative;
            text-align: center;
            cursor: pointer;
        }
        .rune-icon-wrapper img {
            width: 64px;
            height: 64px;
            object-fit: contain;
        }
        .tooltip {
            visibility: hidden;
            background-color: rgba(0, 0, 0, 0.85);
            color: #fff;
            text-align: left;
            border-radius: 6px;
            padding: 8px 10px;
            position: absolute;
            z-index: 1;
            width: 200px;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 8px;
            font-size: 0.85em;
            line-height: 1.4;
        }
        .rune-icon-wrapper:hover .tooltip {
            visibility: visible;
        }
    </style>
</head>
<body>
    <h1>ルーン一覧</h1>

    @if(isset($message))
        <p class="message">{{ $message }}</p>
    @endif

    @if($runes->isNotEmpty())
        <div class="runes-grid">
            @foreach($runes as $rune)
                <div class="rune-icon-wrapper">
                    <img src="https://ddragon.leagueoflegends.com/cdn/img/{{ $rune->icon }}" alt="{{ $rune->name }}">
                    <div class="tooltip">
                        <strong>{{ $rune->name }}</strong><br>
                        <em>{{ $rune->key }}</em><br>
                        {{ $rune->shortDesc ?? '説明なし' }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @unless(isset($message))
            <p class="message">表示できるルーンがありません。</p>
        @endunless
    @endif
</body>
</html>
