<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class chekorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oredr:chekorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stop orders older than 45 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ex_date = now()->subDays(45);
        $updatedOrders = Order::where('active', '1')
            ->whereNotNull('suspension_date')
            ->where('suspension_date', '<', $ex_date)
            ->update(['active' => '0']);
        if ($updatedOrders) {
            Log::info("$updatedOrders orders have been deactivated.");
        } else {
            Log::info("No orders were updated.");
        }

    }
}
