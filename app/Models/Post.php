<?php
namespace App\Models;
use App\Models\Rune;
use App\Models\Item;
use App\Models\Lane;
use App\Models\Champion;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // ...既存の use や fillable の定義など...
    protected $fillable = [
        'id',
        'user_id',
        'lane_id',
        'champion_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];

    // レーン（1対多）
    public function lane()
    {
        return $this->belongsTo(Lane::class);
    }

    // チャンピオン（1対多）
    public function champion()
    {
        return $this->belongsTo(Champion::class);
    }

    // ルーン（多対多）
    public function runes()
    {
        return $this->belongsToMany(Rune::class);
    }

    // アイテム（多対多＋順序つきなら order も欲しい）
    public function items()
    {
        return $this->belongsToMany(Item::class, 'post_item');
        
    }
}
