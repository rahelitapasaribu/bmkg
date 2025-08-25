<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    protected $table = 'staf'; // Nama tabel di database

    protected $fillable = [
        'id_satker',
        'asn_laki',
        'asn_perempuan',
        'ppnpn_laki',
        'ppnpn_perempuan'
    ];

    // Relasi: staf milik satu satker
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'id_satker', 'id');
    }
}
