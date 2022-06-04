<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = clean($value);
    }
}
