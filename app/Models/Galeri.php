<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;
    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_galeri',
        'jenis_galeri',
        'keterangan_galeri',
        'gambar_galeri',
        'gambar_galeri1',
        'gambar_galeri2',
        'gambar_galeri3',
        'video_galeri',
    ];
}
