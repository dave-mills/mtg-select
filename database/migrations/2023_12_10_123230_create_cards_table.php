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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('scryfall_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->string('name');
            $table->string('rarity');
            $table->boolean('foil')->default(false);
            $table->decimal('purchase_price', 8, 2)->nullable();
            $table->text('scryfall_data')->nullable();
            $table->text('oracle_text')->nullable();
            $table->text('type_line')->nullable();
            $table->string('set_code')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
