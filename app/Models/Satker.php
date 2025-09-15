<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    use HasFactory;

    protected $table = 'satker';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id_provinsi', 'nama_satker', 'latitude', 'longitude'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }

    public function alatSatker()
    {
        return $this->hasMany(AlatSatker::class, 'satker_id', 'id');
    }

    public function staf()
    {
        return $this->hasOne(Staf::class, 'id_satker', 'id');
    }

    public function siteSatkers()
    {
        return $this->hasMany(SiteSatker::class, 'satker_id', 'id');
    }
}
