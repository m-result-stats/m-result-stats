<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchResult extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 主キー
     */
    protected $primaryKey = 'match_result_id';

    /**
     * 試合情報テーブルとの結合
     */
    public function matchInformation(): HasOne
    {
        return $this->HasOne(MatchInformation::class, 'match_id', 'match_id');
    }

    /**
     * 選手テーブルとの結合
     */
    public function player(): HasOne
    {
        return $this->HasOne(Player::class, 'player_id', 'player_id');
    }

    /**
     * 選手での絞り込み
     */
    public function scopeEqualPlayerId(Builder $query, int $value): void
    {
        $query->where('player_id', $value);
    }
}
