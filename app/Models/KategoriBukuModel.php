<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBukuModel extends Model
{
    use HasFactory;

    protected $table = "kategori_buku";
    protected $primaryKey = 'kategori_id';


    protected $fillable = [
        'nama_kategori',
        'cover',
    ];


    protected $casts = [
    ];

    public function buku()
    {
        return $this->hasMany(KategoriBukuRelasiModel::class, 'kategori_id');
    }
}
