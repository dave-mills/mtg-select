<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_library_entries', function (Blueprint $table) {
            $table->string('scryfall_id')->primary();
            $table->string('rarity');
            $table->string('name');
            $table->string('purchase_price');
            $table->text('scryfall_data');
            $table->text('oracle_text');
            $table->text('type_line');
            $table->string('set_code');
            $table->text('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_library_entries');
    }
};
