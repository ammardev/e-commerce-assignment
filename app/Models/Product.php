<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
                    $columns[$nameIndex] = DB::raw('IFNULL(product_translations.name, products.name) AS name');
                }

                if ($descriptionIndex !== false) {
                    $columns[$descriptionIndex] = DB::raw('IFNULL(product_translations.description, products.description) AS description');
                }
                
                $builder->select($columns)->leftJoin('product_translations', function($join) use ($locale) {
                    $join->on('product_translations.product_id', '=', 'products.id')
                        ->where('product_translations.language', $locale);
                });
            });
        }
    }
}
