<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Replytemplate
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort_order
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Replytemplate whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Replytemplate extends Model
{
    use RevisionableTrait;

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function assignProduct($product_id){
        if(!$this->products->contains(Product::whereId($product_id)->first()->id)){
            $this->products()->attach(Product::whereId($product_id)->first());
        }
        return $this;
    }
    public function revokeProduct($product_id){
        $this->products()->detach(Product::whereId($product_id)->first());
        return $this;
    }
}
