<?php

namespace App\Models\Transaction;

use App\Models\Transaction;

class ShiftClose extends Transaction
{
    public int $type = self::TYPE_SHIFT_CLOSE;

    protected static $singleTableType = self::TYPE_SHIFT_CLOSE;

    public function makeRequest(): string
    {
        $this->request = view('tax.contents.shift', ['transaction' => $this])->render();

        return $this->request;
    }
}
