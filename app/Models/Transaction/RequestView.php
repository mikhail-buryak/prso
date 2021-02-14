<?php

namespace App\Models\Transaction;

interface RequestView
{
    public function makeRequest(): string;
}
