<?php

namespace App\Models\Transaction\Sub;

use App\Models\Transaction\Receipt;

class Validate extends Receipt
{
    public int $sub_type = self::SUB_TYPE_VALIDATE;
}
