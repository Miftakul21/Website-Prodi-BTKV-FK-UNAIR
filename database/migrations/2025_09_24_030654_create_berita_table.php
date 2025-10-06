<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            $table->longText('slug')->nullable()->unique();
            $table->integer('viewers')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // relasi tabel berita -> user
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->getKeyName())) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            if (empty($mode->slug)) {
                $model->slug = static::generateUniqueSlug($model->judul);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) || $model->isDirty('judul')) {
                $model->slug = static::generateUniqueSlug($model->judul);
            }
        });
    }

    protected static function generateUniqueSlug($judul)
    {
        $baseSlug = Str::slug($judul);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$slug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
