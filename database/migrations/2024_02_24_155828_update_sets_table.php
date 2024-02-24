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
        Schema::table('sets', function (Blueprint $table) {
            $table->string('set_type')->nullable();
            $table->integer('card_count')->nullable();
            $table->boolean('digital')->nullable();
            $table->boolean('nonfoil_only')->nullable();
            $table->boolean('foil_only')->nullable();
            $table->string('icon_svg_uri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
