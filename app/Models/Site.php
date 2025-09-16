<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'sites';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_jenis_alat',
        'nama_site',
        'merk',
        'tahun_pengadaan',
    ];

    public function jenisAlat()
    {
        return $this->belongsTo(JenisAlat::class, 'id_jenis_alat', 'id');
    }

    public function siteSatkers()
    {
        return $this->hasMany(SiteSatker::class, 'site_id', 'id');
    }

    public function slaOlaNilai()
    {
        return $this->hasMany(SlaOlaNilai::class, 'site_id', 'id');
    }

    public function satker()
    {
        return $this->hasOneThrough(
            Satker::class,
            SiteSatker::class,
            'site_id', // Foreign key on SiteSatker table
            'id',      // Foreign key on Satker table
            'id',      // Local key on Site table
            'satker_id' // Local key on SiteSatker table
        );
    }
}
