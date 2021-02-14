<?php

namespace App\Models\Transaction;

use App\Models\Transaction;

class Receipt extends Transaction implements RequestView
{
    const SUB_TYPE_VALIDATE = 0;
    const SUB_TYPE_REFUND = 1;
    const SUB_TYPE_CANCEL = 5;

    public int $type = self::TYPE_RECEIPT;

    public function makeRequest(): string
    {
        $this->request = view('tax.contents.receipt', ['transaction' => $this, 'receipt' => $this->receipt])->render();

        return $this->request;
    }
}
