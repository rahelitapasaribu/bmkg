<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['category_id', 'merk', 'id_satker', 'name'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function performance()
    {
        return $this->hasMany(performance::class);
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'id_satker');
    }
}
