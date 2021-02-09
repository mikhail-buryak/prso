<?php

namespace App\Requests\Registrar;

class Update
{
    public static function getValidationRules(): array
    {
        return [
            'unit_id' => 'numeric|exists:units,id',
            'number_local' => 'string|max:255',
            'number_fiscal' => 'string|max:255',
            'name' => 'string|max:255',
            'on' => 'boolean',
            'closed' => 'boolean',
        ];
    }
}
