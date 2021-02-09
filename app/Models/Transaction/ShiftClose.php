<?php

namespace App\Models\Transaction;

use App\Models\Transaction;

class ShiftClose extends Transaction
{
    protected static $singleTableType = self::TYPE_SHIFT_CLOSE;

    public function makeRequest(): static
    {
        // TODO: Implement makeRequest() method.

        $this->request = 'xml-view';

        return $this;
    }
}
