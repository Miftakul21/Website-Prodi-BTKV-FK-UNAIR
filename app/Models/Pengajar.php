<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pengajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengajar';
    protected $primaryKey = 'id_pengajar';
    public $incrementing = false;
    protected $keyType = 'string';

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
