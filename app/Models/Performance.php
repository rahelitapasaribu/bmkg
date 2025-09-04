<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    // protected $table = 'performance';

    protected $fillable = ['site_id', 'year', 'month', 'percentage'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
