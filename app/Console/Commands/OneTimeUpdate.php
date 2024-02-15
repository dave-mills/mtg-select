<?php

namespace App\Console\Commands;

use App\Enums\WantStatus;
use App\Models\CardWant;
use Illuminate\Console\Command;

class OneTimeUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:one-time-update';

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
        $wants = CardWant::all()
            ->each(function (CardWant $want) {
                if($want->state === WantStatus::NotWant->value) {
                    $want->not_want = true;
                }

                if($want->state === WantStatus::Want->value) {
                    $want->want = true;
                }

                if($want->state === WantStatus::ReallyWant->value) {
                    $want->really_want = true;
                }

                if($want->state === WantStatus::ReallyReallyWant->value) {
                    $want->really_really_want = true;
                }

                $want->save();
            });
    }
}
