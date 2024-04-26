<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuReadModel extends Model
{
    use HasFactory;

    protected $table = "buku_read";
    protected $primaryKey = 'buku_read_id';

    protected $fillable = [
        'buku_id',
        'user_id'
    ];

    protected $casts = [
        'buku_id' => 'integer',
        'user_id' => "integer",
    ];

    public function buku()
    {
        return $this->belongsTo(BukuModel::class, "buku_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
