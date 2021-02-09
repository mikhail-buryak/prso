<?php

namespace App\Requests\Unit;

class Update
{
    public static function getValidationRules(): array
    {
        return [
            'legal_id' => 'numeric|exists:legals,id',
            'tax_id' => 'string|max:255',
            'tin' => 'string|max:10',
            'ipn' => 'string|max:12',
            'name' => 'string|max:255',
            'org_name' => 'string|max:255',
            'address' => 'string|max:255'
        ];
    }
}
