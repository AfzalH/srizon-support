<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


/**
 * App\Order
 *
 * @property integer $id
 * @property integer $p_id
 * @property string $p_date
 * @property string $status
 * @property string $country
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $product_name
 * @property integer $product_id
 * @property string $payment_method
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereProductName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use RevisionableTrait;

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
