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
        Schema::create('artikel', function (Blueprint $table) {
            $table->uuid('id_artikel')->primary();
            $table->uuid('user_id');
            $table->date('tgl_artikel');
            $table->text('judul');
            $table->string('kategori');
            $table->string('thumbnail_image')->nullable();
            $table->text('resource_image')->nullable(); // dapat image dari mana (sosmed/dari internal)
            $table->longText('konten_artikel');
            $table->longText('slug')->nullable()->unique();
            $table->integer('viewers')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        $slug     = $baseSlug;
        $counter  = 1;

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
        Schema::dropIfExists('artikel');
    }
};
