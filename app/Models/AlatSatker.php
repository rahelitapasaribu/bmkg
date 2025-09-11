<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatSatker extends Model
{
    use HasFactory;

    protected $table = 'alat_satker';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['satker_id', 'jenis_alat_id', 'kondisi_id', 'jumlah'];

    // Relasi ke tabel Satker
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'id');
    }

    // Relasi ke tabel JenisAlat
    public function jenisAlat()
    {
        return $this->belongsTo(JenisAlat::class, 'jenis_alat_id', 'id');
    }

    // Relasi ke tabel KondisiAlat
    public function kondisi()
    {
        return $this->belongsTo(KondisiAlat::class, 'kondisi_id', 'id');
    }
}
