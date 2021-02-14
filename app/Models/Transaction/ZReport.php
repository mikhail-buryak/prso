<?php

namespace App\Models\Transaction;

use App\Models\Transaction;
use App\Services\Tax\Command;

class ZReport extends Transaction implements RequestView
{
    public int $type = self::TYPE_Z_REPORT;

    public function makeRequest(): string
    {
        /** @var Command $command */
        $command = app(Command::class);

        $this->request = view('tax.contents.z-report', [
            'transaction' => $this,
            'totals' => $command->setLegal($this->legal)->lastShiftTotals($this->registrar)
        ])->render();

        return $this->request;
    }
}
