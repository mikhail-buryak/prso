<?php

namespace App\Requests\Legal;

class Update
{
    public static function getValidationRules()
    {
        return [
            'tin' => 'string|max:10|unique:legals',
            'total_max' => 'numeric',
            'passphrase' => 'string|max:255',
            'key' => 'file|max:4096',
            'cert' => 'file|max:4096',
        ];
    }
}
