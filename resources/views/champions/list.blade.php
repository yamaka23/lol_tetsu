<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャンピオン一覧</title>
    <style>
        /* ... (スタイルは前回と同様) ... */
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        h1 { text-align: center; color: #1e3a5f; }
        .champions-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; }
        .champion-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .champion-card img {
            width: 100px; height: 100px; object-fit: cover;
            border-radius: 4px; margin-bottom: 10px;
        }
        .champion-card h2 { font-size: 1.1em; margin: 10px 0 5px; color: #0a1d36; }
        .champion-card .difficulty { font-size: 0.9em; color: #777; margin-top: 5px; }
        .message { text-align: center; font-size: 1.1em; margin-top: 30px; }
    </style>
</head>
<body>
    <h1>チャンピオン一覧</h1>

    @if(isset($message))
        <p class="message">{{ $message }}</p>
    @endif

    @if($champions->isNotEmpty())
        <div class="champions-grid">
            @foreach($champions as $champion)
                <div class="champion-card">
                    @if($champion->image && $champion->version)
                        <img src="https://ddragon.leagueoflegends.com/cdn/{{ $champion->version }}/img/champion/{{ $champion->image }}" alt="{{ $champion->name }}">
                    @else
                        <div style="width:100px; height:100px; background:#eee; margin:0 auto 10px; display:flex; align-items:center; justify-content:center;">No Image</div>
                    @endif
                    <h2>{{ $champion->name }}</h2>
                    <p class="difficulty">難易度: {{ $champion->difficulty ?? 'N/A' }}</p>
                </div>
            @endforeach
        </div>
    @else
        @unless(isset($message))
            <p class="message">表示できるチャンピオンがいません。</p>
        @endunless
    @endif
</body>
</html>












