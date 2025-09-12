<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;

    protected $table = 'staf';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'satker_id',
        'asn_laki',
        'asn_perempuan',
        'ppnpn_laki',
        'ppnpn_perempuan'
    ];

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'id');
    }
}
