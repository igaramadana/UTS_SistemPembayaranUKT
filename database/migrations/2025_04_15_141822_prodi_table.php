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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id('prodi_id');
            $table->unsignedBigInteger('jurusan_id')->index();
            $table->string('prodi_kode', 5)->unique();
            $table->string('prodi_nama', 50);
            $table->timestamps();

            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
