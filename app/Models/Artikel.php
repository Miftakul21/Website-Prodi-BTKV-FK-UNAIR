<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_artikel',
        'user_id',
        'tgl_artikel',
        'judul',
        'slug',
        'kategori',
        'thumbnail_image',
        'konten_artikel',
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
            Cache::forget('artikel_all');
        });

        static::deleted(function () {
            Cache::forget('artikel_all');
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
