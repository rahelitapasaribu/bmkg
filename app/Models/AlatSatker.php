<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatSatker extends Model
{
    use HasFactory;

    protected $table = 'alat_satker'; // nama tabel
    protected $fillable = ['id_satker', 'id_alat', 'jumlah'];
    public $timestamps = false;

    // Relasi ke tabel satker
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'id_satker', 'id');
    }

    // Relasi ke tabel alat
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id');
    }
}
