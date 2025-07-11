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
       Schema::table('poygons', function (Blueprint $table) {
            $table->enum('warna_pada_visualisasi', ['hijau muda', 'hijau tua', 'kuning muda', 'kuning tua', 'merah'])->nullable();
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
