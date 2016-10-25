<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


/**
 * App\Productcategory
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property string $description
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productcategory whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Productcategory extends Model
{
    use RevisionableTrait;

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
