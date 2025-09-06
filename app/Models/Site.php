<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $fillable = [
    'category_id', 
    'merk', 
    'id_satker', 
    'name'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function performances()
    {
        return $this->hasMany(Performance::class, 'site_id');
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'id_satker');
    }

}
