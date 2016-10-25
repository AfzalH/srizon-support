<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Ticketstatus
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketstatus whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Ticketstatus extends Model
{
    protected $visible = ['name'];
    use RevisionableTrait;

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
