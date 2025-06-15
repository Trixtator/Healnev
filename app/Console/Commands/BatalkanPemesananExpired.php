<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BatalkanPemesananExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batalkan-pemesanan-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Pemesanan::where('status', 'pending')
        ->where('dibuat_pada', '<', now()->subHours(2))
        ->update(['status' => 'expired']);
    }
}
