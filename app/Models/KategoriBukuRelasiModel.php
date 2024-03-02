<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBukuRelasiModel extends Model
{
    use HasFactory;

    protected $table = "kategori_buku_relasi";
    protected $primaryKey = 'kategori_buku_relasi_id';


    protected $fillable = [
        'kategori_id',
        'buku_id',
    ];

    protected $casts = [
        'buku_id' => 'integer',
        'kategori_id' => 'integer',
    ];

    public function detail_kategori()
    {
        return $this->hasOne(KategoriBukuModel::class, 'kategori_id');
    }

}
