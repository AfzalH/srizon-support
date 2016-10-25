<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Product
 *
 * @property integer $id
 * @property string $name
 * @property string $paypro_name
 * @property string $description_url
 * @property string $docs_url
 * @property string $demo_url
 * @property string $purchase_url
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productcategory[] $productcategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Replytemplate[] $replytemplates
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productlink[] $downloadlinks
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePayproName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDescriptionUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDocsUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDemoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePurchaseUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 */
class Product extends Model
{

    protected $visible = ['name'];
    use RevisionableTrait;

    public static function boot() {
        parent::boot();
        if(! \Schema::hasTable('tickets')) return;

        static::deleting(function(Product $product) {
            foreach($product->tickets as $ticket){
                $ticket->product_id = 1;
                $ticket->save();
            }
            foreach($product->orders as $order){
                $order->product_id = 1;
                $order->save();
            }
        });
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function productcategories(){
        return $this->belongsToMany(Productcategory::class);
    }

    public function replytemplates(){
        return $this->belongsToMany(Replytemplate::class);
    }

    public function downloadlinks(){
        return $this->hasMany(Productlink::class);
    }

    public function assignCategory($cat_id){
        if(!$this->productcategories->contains(Productcategory::whereId($cat_id)->first()->id)){
            $this->productcategories()->attach(Productcategory::whereId($cat_id)->first());
        }
        return $this;
    }
    public function revokeCategory($cat_id){
            $this->productcategories()->detach(Productcategory::whereId($cat_id)->first());
        return $this;
    }
    public function assignReplyTemplate($reply_id){
        if(!$this->replytemplates->contains(Replytemplate::whereId($reply_id)->first()->id)){
            $this->replytemplates()->attach(Replytemplate::whereId($reply_id)->first());
        }
        return $this;
    }
    public function revokeReplyTemplate($reply_id){
        $this->replytemplates()->detach(Replytemplate::whereId($reply_id)->first());
        return $this;
    }
}
