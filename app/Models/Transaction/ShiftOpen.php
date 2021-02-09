<?php

namespace App\Models\Transaction;

use App\Models\Transaction;

class ShiftOpen extends Transaction
{
    protected static $singleTableType = self::TYPE_SHIFT_OPEN;

    public function makeRequest(): static
    {
        // TODO: Implement makeRequest() method.

        $this->request = 'xml-view';

        return $this;
    }
}
