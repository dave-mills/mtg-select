<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CardTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('card_types')->delete();
        
        \DB::table('card_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Creature',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Instant',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Sorcery',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Enchantment',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Artifact',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Planeswalker',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Land',
                'created_at' => '2023-12-10 14:31:27',
                'updated_at' => '2023-12-10 14:31:27',
            ),
        ));
        
        
    }
}