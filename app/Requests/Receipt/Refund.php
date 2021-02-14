<?php

namespace App\Requests\Receipt;

use Illuminate\Http\Request;

class Refund
{
    public static function getValidationRules(): array
    {
        return [];
    }

    public static function map(Request $request): array
    {
        $data = $request->all();

        $meta = $data['meta'];
        unset($data['meta']);

        return [
            'order_code' => $meta['order_code'],
            'sum' => $data['total']['sum'],
            'data' => $data
        ];
    }
}
