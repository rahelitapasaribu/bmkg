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
        'site_id',
        'jenis_alat_id',
        'tipe_id',
        'tahun',
        'bulan',
        'persentase',
    ];

    public function kategori()
    {
        return $this->belongsTo(TipeKategori::class, 'tipe_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function jenisAlat()
    {
        return $this->belongsTo(JenisAlat::class, 'jenis_alat_id', 'id');
    }
}
