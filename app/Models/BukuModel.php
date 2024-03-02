<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuModel extends Model
{
    use HasFactory;

    protected $table = "buku";
    protected $primaryKey = 'buku_id';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'is_premium',
        'cover',
        'ebook_path',
        'ebook_format',
        'ebook_size',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'is_premium' => "integer",
    ];

    public function daftar_kategori()
    {
        return $this->hasMany(KategoriBukuRelasiModel::class, 'buku_id')->with("detail_kategori");
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanModel::class, 'buku_id');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanBukuModel::class, 'buku_id');
    }

    public function koleksi()
    {
        return $this->hasMany(KoleksiPribadiModel::class, 'buku_id');
    }

}
