<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Ticket
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $secret
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $ticketstatus_id
 * @property integer $ticketcategory_id
 * @property integer $user_id
 * @property string $extra_fields
 * @property string $email_code
 * @property boolean $email_verified
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Ticketcategory $ticketcategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticketpost[] $ticketposts
 * @property-read \App\User $user
 * @property-read \App\Ticketstatus $ticketstatus
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereSecret($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTicketstatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTicketcategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereExtraFields($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereEmailCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereEmailVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Ticket extends Model implements SluggableInterface
{
    protected $visible = ['id','title','ticketcategory','ticketposts','user','ticketstatus','product'];
    use SluggableTrait;
    use RevisionableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    public static function boot() {
        parent::boot();
        if(! \Schema::hasTable('ticketposts')) return;

        static::deleting(function(Ticket $ticket) {
            $ticket->ticketposts()->delete();
        });
    }

    public function ticketcategory(){
        return $this->belongsTo(Ticketcategory::class);
    }

    public function ticketposts(){
        return $this->hasMany(Ticketpost::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ticketstatus(){
        return $this->belongsTo(Ticketstatus::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
