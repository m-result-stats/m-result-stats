<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 主キー
    protected $primaryKey = 'match_date';
    /**
     * 主キーのデータ型
     */
    protected $keyType = 'date';

    /**
     * シーズンテーブルとの結合
     */
    public function season(): HasOne
    {
        return $this->HasOne(Season::class, 'season_id', 'season_id');
    }

    /**
     * 試合区分テーブルとの結合
     */
    public function match_category(): HasOne
    {
        return $this->HasOne(MatchCategory::class, 'match_category_id', 'match_category_id');
    }

    /**
     * シーズンでの絞り込み
     */
    public function scopeEqualSeasonId(Builder $query, int $value): void
    {
        $query->where('season_id', $value);
    }

    /**
     * 試合区分での絞り込み
     */
    public function scopeEqualMatchCategoryId(Builder $query, int $value): void
    {
        $query->where('match_category_id', $value);
    }

    // ====================
    // アクセサ
    // ====================
    /**
     * 表示用の試合日を取得する
     */
    public function matchDateDisplay(): Attribute
    {
        return Attribute::make(
            get: function() {
                $weeks = ['日','月','火','水','木','金','土',];
                $week_name = $weeks[$this->match_date->format('w')];
                return $this->match_date->format('Y-m-d') . '(' . $week_name . ')';
            }
        );
    }
}
