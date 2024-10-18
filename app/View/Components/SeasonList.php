<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

/**
 * シーズン一覧を表示するリストボックス
 */
class SeasonList extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $seasonId 選択されたシーズンID
     * @param Collection $seasons DBから取得したシーズン
     */
    public function __construct(
        public string $seasonId,
        public Collection $seasons,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.season-list');
    }
}
