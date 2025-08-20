<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provinsi extends Model
{
    use HasFactory;
    protected $table = 'provinsi';
    protected $fillable = ['nama_provinsi'];

    public function satkers()
    {
        return $this->hasMany(Satker::class, 'id_provinsi');
    }
}
