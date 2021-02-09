<?php

namespace App\Models\Transaction\Sub;

use App\Models\Transaction\Receipt;

class Cancel extends Receipt
{
    protected static $singleTableType = self::SUB_TYPE_CANCEL;

    public function makeRequest(): static
    {
        // TODO: Implement makeRequest() method.

        $this->request = 'xml-view';

        return $this;
    }
}
