<?php

namespace App\Console\Commands;

use App\Models\Registrar;
use App\Services\Tax\Document;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseShifts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shifts:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Closes shifts to all registrars who have it open';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Document $document
     */
    public function handle(Document $document)
    {
        $registrars = Registrar::with(['unit', 'legal'])
            ->where('closed', false)
            ->whereDate('opened_at', Carbon::today())
            ->get();

        foreach ($registrars as $registrar) {
            $document->zReport($registrar);
            $document->shiftClose($registrar);
        }
    }
}
