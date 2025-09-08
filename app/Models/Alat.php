<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat'; // nama tabel
    protected $fillable = ['nama_alat'];
    public $timestamps = false;

    // Relasi ke tabel alat_satker
    public function alatSatker()
    {
        return $this->hasMany(AlatSatker::class, 'id_alat', 'id');
    }
}
