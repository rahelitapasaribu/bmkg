<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'sites';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'jenis_alat_id',
        'satker_id',
        'merk',
        'name',
    ];

    public function jenisAlat()
    {
        return $this->belongsTo(JenisAlat::class, 'jenis_alat_id', 'id');
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'id');
    }
}
