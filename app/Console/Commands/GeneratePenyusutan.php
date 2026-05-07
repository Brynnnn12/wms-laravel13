<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Services\PenyusutanService;
use Carbon\Carbon;


#[Signature('penyusutan:generate {--bulan=} {--tahun=}')]
#[Description('Generate penyusutan aset untuk periode tertentu')]
class GeneratePenyusutan extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(PenyusutanService $service): int
    {
        $target = Carbon::now()->subMonth();
        $bulan = (int) ($this->option('bulan') ?? $target->month);
        $tahun = (int) ($this->option('tahun') ?? $target->year);

        $service->processDepreciation($bulan, $tahun);

        $this->info("Penyusutan berhasil digenerate untuk periode {$bulan}/{$tahun}.");

        return Command::SUCCESS;
    }
}
