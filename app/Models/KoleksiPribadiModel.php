<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoleksiPribadiModel extends Model
{
    use HasFactory;

    protected $table = "koleksi_pribadi";
    protected $primaryKey = 'koleksi_pribadi_id';


    protected $fillable = [
        'user_id',
        'buku_id',
    ];


    protected $casts = [
        'user_id' => 'integer',
        'kategori_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(BukuModel::class, 'buku_id');
    }
}
