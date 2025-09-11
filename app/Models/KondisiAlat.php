<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiAlat extends Model
{
    use HasFactory;

    protected $table = 'kondisi_alat';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nama_kondisi'];

    public function alatSatker()
    {
        return $this->hasMany(AlatSatker::class, 'kondisi_id', 'id');
    }
}
