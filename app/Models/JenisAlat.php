<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAlat extends Model
{
    use HasFactory;

    protected $table = 'jenis_alat';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['nama_jenis'];

    public function alatSatker()
    {
        return $this->hasMany(AlatSatker::class, 'jenis_alat_id', 'id');
    }

    public function sites()
    {
        return $this->hasMany(Site::class, 'id_jenis_alat', 'id');
    }

    public function slaOlaNilai()
    {
        return $this->hasMany(SlaOlaNilai::class, 'jenis_alat_id', 'id');
    }
}
