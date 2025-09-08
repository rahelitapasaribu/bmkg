<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Satker extends Model
{
    use HasFactory;
    protected $table = 'satker';
    protected $fillable = ['id_provinsi', 'nama_satker', 'latitude', 'longitude'];
    public $timestamps = false;

    // Relasi ke Provinsi
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }

    public function alatSatker()
    {
        return $this->hasMany(AlatSatker::class, 'id_satker');
    }
    public function staf()
    {
        return $this->hasOne(Staf::class, 'id_satker');
    }
}
