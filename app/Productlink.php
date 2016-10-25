<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Productlink
 *
 * @property integer $id
 * @property string $version
 * @property string $filename
 * @property string $notes
 * @property integer $product_id
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productlink whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Productlink extends Model
{
    use RevisionableTrait;

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
