<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanBukuModel extends Model
{
    use HasFactory;


    protected $table = "ulasan_buku";
    protected $primaryKey = 'ulasan_buku_id';


    protected $fillable = [
        'user_id',
        'buku_id',
        'ulasan',
        'rating',
    ];


    protected $casts = [
        'user_id' => 'integer',
        'buku_id' => 'integer',
        'rating' => 'integer',
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
