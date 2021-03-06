<?php

namespace App\Models\Transaction;

use App\Models\Transaction;

class ShiftOpen extends Transaction implements RequestView
{
    public int $type = self::TYPE_SHIFT_OPEN;

    public function makeRequest(): string
    {
        $this->request = view('tax.contents.shift', ['transaction' => $this])->render();

        return $this->request;
    }
}
