<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'name',
        'image',
        'language',
        'description',
        'gold',
        'tags',
        'stats',
        'version',
        'is_into',
        'inStore',
        'requiredChampion',
        'maps',
    ];

    protected $casts = [
        'tags' => 'array',
        'stats' => 'array',
        'gold' => 'array',
        'maps' => 'array',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_item')->withPivot('order');
    }

    public function getMapsAttribute($value)
    {
        $maps = json_decode($value, true);
        return collect($maps)
            ->mapWithKeys(fn($v, $k) => [$k => filter_var($v, FILTER_VALIDATE_BOOLEAN)])
            ->toArray();
    }

    public function setMapsAttribute($value)
    {
        $this->attributes['maps'] = json_encode(
            collect($value)
                ->mapWithKeys(fn($v, $k) => [$k => filter_var($v, FILTER_VALIDATE_BOOLEAN)])
                ->toArray()
        );
    }

    /**
     * 一般アイテム用のクエリスコープ
     */
    public function scopeGeneral($query)
    {
        return $query->where(function($query) {
                $query->whereNull('requiredChampion')
                      ->orWhere('requiredChampion', '');
            })
            ->where('maps->11', '=', true) // Summoner's Rift
            ->where('inStore', '=', true)
            ->where('gold->total', '>', 0)
            ->where(function($q) {
                $q->whereJsonDoesntContain('tags', 'Consumable')
                  ->whereJsonDoesntContain('tags', 'Trinket')
                  ->whereJsonDoesntContain('tags', 'Jungle')
                  ->whereJsonDoesntContain('tags', 'GoldPer')
                  ->whereJsonDoesntContain('tags', 'Lane');
            });
    }
}
