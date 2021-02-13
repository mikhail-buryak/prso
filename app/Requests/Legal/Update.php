<?php

namespace App\Requests\Legal;

class Update
{
    public static function getValidationRules(): array
    {
        return [
            'tin' => 'string|max:10|unique:legals',
            'passphrase' => 'string|max:255',
            'key' => 'file|max:4096',
            'cert' => 'file|max:4096',
        ];
    }
}
