<?php

namespace App\Models\Transaction\Sub;

use App\Models\Transaction\Receipt;

class Cancel extends Receipt
{
    public int $sub_type = self::SUB_TYPE_CANCEL;

    public int|null $cancelNumberFiscal;

    public function makeRequest(): string
    {
        $this->request = view('tax.contents.cancel', ['transaction' => $this])->render();

        return $this->request;
    }
}
