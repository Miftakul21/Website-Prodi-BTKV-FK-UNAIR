<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Model Berita ini tidak hanya mengelola artikel berita saja,
     * tetapi acara (workshop, seminar), hasil karya
     */

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_berita',
        'user_id',
        'tgl_berita',
        'judul',
        'slug',
        'kategori',
        'thumbnail_image',
        'konten_berita',
        'viewers',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->judul);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) || $model->isDirty('judul')) {
                $model->slug = static::generateUniqueSlug($model->judul);
            }
        });
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('berita_all');
        });

        static::deleted(function () {
            Cache::forget('berita_all');
        });
    }

    protected static function generateUniqueSlug($judul)
    {
        $baseSlug = Str::slug($judul);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }
        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
