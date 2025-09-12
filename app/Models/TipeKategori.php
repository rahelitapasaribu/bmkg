<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeKategori extends Model
{
    use HasFactory;

    protected $table = 'tipe_kategori';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nama_tipe'];

    public function slaOlaNilai()
    {
        return $this->hasMany(SlaOlaNilai::class, 'tipe_id', 'id');
    }
}
