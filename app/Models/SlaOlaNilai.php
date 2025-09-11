<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlaOlaNilai extends Model
{
    use HasFactory;

    protected $table = 'sla_ola_nilai';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kategori_id',
        'nama',
        'nilai',
        'keterangan',
    ];

    // Relasi ke TipeKategori
    public function kategori()
    {
        return $this->belongsTo(TipeKategori::class, 'kategori_id', 'id');
    }
}
