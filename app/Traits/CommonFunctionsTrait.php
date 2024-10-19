<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * 共通関数をまとめたトレイト
 */
trait CommonFunctionsTrait
{
    /**
     * リクエスト内に存在しないクエリパラメータをリクエストに追加する
     *
     * @param Request $request
     * @param array $addQueryParameters 追加クエリパラメータ
     */
    public function addQueryParameter(Request $request, array $addQueryParameters)
    {
        foreach ($addQueryParameters as $addQueryParameter) {
            if ($request->query($addQueryParameter) == null) {
                $request->merge([
                    $addQueryParameter => 0,
                ]);
            }
        }
    }
}
