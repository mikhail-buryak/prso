<?php

namespace App\Models\Transaction\Sub;

use App\Models\Transaction\Receipt;

class Refund extends Receipt
{
    public int $sub_type = self::SUB_TYPE_REFUND;
}
