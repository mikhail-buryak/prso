<?php

namespace App\Models\Transaction;

use App\Models\Transaction;
use App\Models\Transaction\Receipt as TReceipt;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

abstract class Receipt extends Transaction
{
    use SingleTableInheritanceTrait;

    const SUB_TYPE_VALIDATE = 0;
    const SUB_TYPE_REFUND = 1;
    const SUB_TYPE_CANCEL = 5;

    protected static $singleTableType = self::TYPE_RECEIPT;

    protected static $singleTableTypeField = 'sub_type';

    protected static $singleTableSubclasses = [
        ShiftOpen::class,
        TReceipt::class,
        ZReport::class,
        ShiftClose::class,
    ];
}
