<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = ['store_id'];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = clean($value);
    }
}
