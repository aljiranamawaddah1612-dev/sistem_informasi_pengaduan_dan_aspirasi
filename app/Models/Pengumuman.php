<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'isi_pengumuman', 'tanggal_publish', 'gambar', 'penulis_id'];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
