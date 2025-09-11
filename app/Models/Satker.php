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

    protected $fillable = ['provinsi_id', 'nama_satker', 'latitude', 'longitude'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id');
    }

    public function alatSatker()
    {
        return $this->hasMany(AlatSatker::class, 'satker_id', 'id');
    }

    public function staf()
    {
        return $this->hasOne(Staf::class, 'satker_id', 'id');
    }

    public function sites()
    {
        return $this->hasMany(Site::class, 'satker_id', 'id');
    }
}
