<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.php
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->uuid('id_berita')->primary();
            $table->uuid('user_id');
            $table->date('tgl_berita');
            $table->text('judul');
            $table->string('kategori');
            $table->string('thumbnail_image');
            $table->longText('konten_berita');
            $table->integer('viewers')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // relasi tabel berita -> user
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
