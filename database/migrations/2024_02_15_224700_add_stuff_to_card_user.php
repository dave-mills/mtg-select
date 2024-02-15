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
        Schema::table('card_user', function (Blueprint $table) {
            $table->boolean('not_want')->default(false);
            $table->boolean('want')->default(false);
            $table->boolean('really_want')->default(false);
            $table->boolean('really_really_want')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_user', function (Blueprint $table) {
            //
        });
    }
};
