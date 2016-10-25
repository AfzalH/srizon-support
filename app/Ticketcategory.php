<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Ticketcategory
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketcategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketcategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketcategory whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketcategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketcategory whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Ticketcategory extends Model
{
    protected $visible = ['name'];
    use RevisionableTrait;

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
