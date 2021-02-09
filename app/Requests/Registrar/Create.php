<?php

namespace App\Requests\Registrar;

class Create
{
    public static function getValidationRules(): array
    {
        return [
            'unit_id' => 'required|numeric|exists:units,id',
            'number_local' => 'required|string|max:255',
            'number_fiscal' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'on' => 'boolean',
            'closed' => 'boolean',
        ];
    }
}
