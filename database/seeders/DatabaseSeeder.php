<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CardType;
use App\Models\Colour;
use Doctrine\DBAL\Schema\Column;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Colour::create([
            'abbr' => 'W',
            'name' => 'White',
        ]);

        Colour::create([
            'abbr' => 'U',
            'name' => 'Blue',
        ]);

        Colour::create([
            'abbr' => 'B',
            'name' => 'Black',
        ]);

        Colour::create([
            'abbr' => 'R',
            'name' => 'Red',
        ]);

        Colour::create([
            'abbr' => 'G',
            'name' => 'Green',
        ]);

        CardType::create([
            'name' => 'Creature',
        ]);

        CardType::create([
            'name' => 'Instant',
        ]);

        CardType::create([
            'name' => 'Sorcery',
        ]);

        CardType::create([
            'name' => 'Enchantment',
        ]);

        CardType::create([
            'name' => 'Artifact',
        ]);

        CardType::create([
            'name' => 'Planeswalker',
        ]);

        CardType::create([
            'name' => 'Land',
        ]);



    }
}
