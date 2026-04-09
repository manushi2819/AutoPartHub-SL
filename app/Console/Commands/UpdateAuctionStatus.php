<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class UpdateAuctionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update auction statuses automatically based on start and end times';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        // 1️⃣ Upcoming → Active
        $upcoming = Auction::where('status', 'upcoming')
            ->where('start_time', '<=', $now)
            ->get();

        foreach ($upcoming as $auction) {
            $auction->status = 'active';
            $auction->save();
            $this->info("Auction #{$auction->id} is now ACTIVE");
        }

        // 2️⃣ Active → Ended
        $active = Auction::where('status', 'active')
            ->where('end_time', '<=', $now)
            ->get();

        foreach ($active as $auction) {
            $auction->status = 'ended';
            $auction->save();
            $this->info("Auction #{$auction->id} is now ENDED");
        }

        return 0;
    }
}