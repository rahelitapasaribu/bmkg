<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSatker extends Model
{
    use HasFactory;

    protected $table = 'site_satker';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'site_id',
        'satker_id',
        'kondisi_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'id');
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiAlat::class, 'kondisi_id', 'id');
    }
}
