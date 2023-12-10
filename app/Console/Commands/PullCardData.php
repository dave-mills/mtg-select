<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\CardLibraryEntry;
use Cerbero\LazyJson\LazyJson;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\LazyCollection;

class PullCardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pull-card-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets card data from the scryfall json data and stores it in the local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get json file from local storage

        Card::all()
            ->each(function (Card $card) {
                $return = Http::get('https://api.scryfall.com/cards/' . $card->scryfall_id)
                ->throw()
                ->json();

                $card->update([
                    'scryfall_data' => json_encode($return),
                    'oracle_text' => $return['oracle_text'] ?? null,
                    'type_line' => $return['type_line'] ?? null,
                    'image' => $return['image_uris']['normal'] ?? null,
                ]);

                $this->info('Updated ' . $card->name);

                sleep(0.2);
            });


    }
}
