<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    protected $table = 'award';
    protected $primaryKey = 'id_award';
    protected $fillable = [
        'nama_award',
        'gambar_award',
        'keterangan_award',
        'slug_award',
    ];
}
