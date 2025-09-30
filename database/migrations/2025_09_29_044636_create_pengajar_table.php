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
        Schema::create('pengajar', function (Blueprint $table) {
            $table->uuid('id_pengajar')->primary();
            $table->string('name');
            $table->string('posisi')->nullable(); // posisi/jabatan
            $table->string('pendidikan')->nullable();
            $table->longText('biografi')->nullable();
            $table->longText('pakar_penelitian')->nullable();
            $table->longText('kepentingan_klinis')->nullable();
            $table->longText('publikasi_penelitian')->nullable();
            $table->longText('prestasi_dan_penghargaan')->nullable();
            $table->string('foto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajar');
    }
};
