<?php

namespace App\Requests\Unit;

class Create
{
    public static function getValidationRules(): array
    {
        return [
            'legal_id' => 'required|numeric|exists:legals,id',
            'tax_id' => 'required|string|max:255',
            'tin' => 'required|string|max:10',
            'ipn' => 'required|string|max:12',
            'name' => 'required|string|max:255',
            'org_name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ];
    }
}
