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
        Schema::create('ukt', function (Blueprint $table) {
            $table->id('ukt_id');
            $table->unsignedBigInteger('prodi_id')->index();
            $table->string('jenis_masuk', 20);
            $table->decimal('nominal_ukt', 12, 2);
            $table->timestamps();

            $table->foreign('prodi_id')->references('prodi_id')->on('prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukt');
    }
};
