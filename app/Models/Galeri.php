<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable =  [
        'id_galeri',
        'judul_galeri',
        'deskripsi',
        'image_utama',
        'image_first',
        'image_second',
        'image_third',
        'image_fourth',
        'kategori',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
