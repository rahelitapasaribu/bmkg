<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSatker extends Model
{
    use HasFactory;

    protected $table = 'site_satker';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'site_id',
        'satker_id',
    ];

    // Relasi ke Site
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    // Relasi ke Satker
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'id');
    }
}
