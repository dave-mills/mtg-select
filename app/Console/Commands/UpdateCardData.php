<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\CardType;
use Illuminate\Console\Command;

class UpdateCardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-card-data';

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
        $types = CardType::all();

        Card::all()
            ->each(function (Card $card) use ($types) {

                $this->info('Updating card: ' . $card->name);

                $this->comment('colours: ' . implode(', ', $card->scryfall_data['colors'] ?? []));

                // update colour
                $card->colours()->sync(
                    collect($card->scryfall_data['colors'] ?? [])
                        ->map(fn(string $colour) => \App\Models\Colour::firstOrCreate(['abbr' => $colour]))
                        ->pluck('id')
                );

                // update card type
                $type_line = $card->scryfall_data['type_line'] ?? null;

                foreach($types as $type) {
                    if(\Str::of($type_line)->contains($type->name)) {
                        $card->cardTypes()->syncWithoutDetaching($type->id);
                    } else {
                        $card->cardTypes()->detach($type->id);
                    }
                }

            });
    }
}
