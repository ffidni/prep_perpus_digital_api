<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanModel extends Model
{
    use HasFactory;

    protected $table = "peminjaman";
    protected $primaryKey = 'peminjaman_id';


    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'tanggal_dikembalikan',
        'status_peminjaman',
        'token',
    ];


    protected $casts = [
        'user_id' => 'integer',
        'buku_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->hasOne(BukuModel::class, 'buku_id');
    }
}
