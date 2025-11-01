<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Pengajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'pengajar';
    protected $primaryKey = 'id_pengajar';
    public $incrementing  = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'id_pengajar',
        'name',
        'posisi',
        'pendidikan',
        'biografi',
        'pakar_penelitian',
        'kepentingan_klinis',
        'publikasi_penelitian',
        'prestasi_dan_penghargaan',
        'foto',
    ];

    protected $casts = [
        'publikasi_penelitian'     => 'array',
        'kepentingan_klinis'       => 'array',
        'prestasi_dan_penghargaan' => 'array',
        'pendidikan'               => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) || $model->isDirty('name')) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('pengajar_all');
        });

        static::deleted(function () {
            Cache::forget('pengajar_all');
        });
    }

    protected static function generateUniqueSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug     = $baseSlug;
        $counter  = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "${baseSlug}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
