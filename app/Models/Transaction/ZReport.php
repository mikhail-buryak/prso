<?php

namespace App\Models\Transaction;

use App\Models\Transaction;

class ZReport extends Transaction
{
    protected static $singleTableType = self::TYPE_Z_REPORT;

    public function makeRequest(): static
    {
        // TODO: Implement makeRequest() method.

        $this->request = 'xml-view';

        return $this;
    }
}
