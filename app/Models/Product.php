<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Locale;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = ['store_id'];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = clean($value);
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    protected static function booted()
    {
        $locale = Locale::getDefault();

        if ($locale != 'en') {
            static::addGlobalScope('translations', function (Builder $builder) use ($locale) {
                $columns = $builder->getQuery()->columns;
                $nameIndex = array_search('name', $columns);
                $descriptionIndex = array_search('description', $columns);
                if ($nameIndex === false && $descriptionIndex === false) {
                    return;
                }

                if ($nameIndex !== false) {
                    $columns[$nameIndex] = 'product_translations.name';
                }

                if ($descriptionIndex !== false) {
                    $columns[$descriptionIndex] = 'product_translations.description';
                }
                
                $builder->select($columns)->join('product_translations', 'product_translations.product_id', '=', 'products.id')
                    ->where('product_translations.language', $locale);
            });
        }
    }
}
