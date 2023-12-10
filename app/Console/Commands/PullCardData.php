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

                // check for multiple faces
                if (!isset($return['image_uris'])) {
                    $image = $return['card_faces'][0]['image_uris']['normal'];
                    $reverseImage = $return['card_faces'][1]['image_uris']['normal'];
                } else {
                    $image = $return['image_uris']['normal'];
                    $reverseImage = null;
                }

                $card->update([
                    'scryfall_data' => $return,
                    'oracle_text' => $return['oracle_text'] ?? null,
                    'type_line' => $return['type_line'] ?? null,
                    'image' => $image,
                    'reverse_image' => $reverseImage,
                ]);

                $this->info('Updated ' . $card->name);

                sleep(0.2);
            });


    }
}
