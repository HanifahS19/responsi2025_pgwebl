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
        $table->enum('jenis_kesehatan_sawit', ['Sehat', 'Sedang', 'Sakit'])->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
