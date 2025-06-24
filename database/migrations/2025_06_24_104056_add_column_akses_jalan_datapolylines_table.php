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
         Schema::table('polylines', function (Blueprint $table) {
            $table->enum('akses_jalan', ['Akses jalan transportasi besar', 'Akses jalan transportasi kecil', 'Akses jalan setapak'])->nullable();
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
