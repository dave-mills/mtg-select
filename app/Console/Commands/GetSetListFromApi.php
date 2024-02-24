<?php

namespace App\Console\Commands;

use App\Models\Set;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetSetListFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-set-list-from-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Goes to the scryfall api and gets the list of all sets and stores it in the local database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get json data from api
        $return = Http::get('https://api.scryfall.com/sets')
            ->throw()
            ->json();

        foreach ($return['data'] as $set) {
            $set = Set::updateOrCreate(
                ['scryfall_id' => $set['id']],
                [
                    'name' => $set['name'],
                    'code' => $set['code'],
                    'released_at' => $set['released_at'],
                    'set_type' => $set['set_type'],
                    'card_count' => $set['card_count'],
                    'digital' => $set['digital'],
                    'nonfoil_only' => $set['nonfoil_only'],
                    'foil_only' => $set['foil_only'],
                    'icon_svg_uri' => $set['icon_svg_uri'],
                ]
            );
        }

        $this->info('Updated ' . count($return['data']) . ' sets');
    }
}
