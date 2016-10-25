<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Ticketpost
 *
 * @property integer $id
 * @property string $body
 * @property integer $ticket_id
 * @property string $secrecy
 * @property integer $user_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Ticket $ticket
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereSecrecy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticketpost whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Ticketpost extends Model
{
    protected $visible = ['id','body','user'];
    use RevisionableTrait;

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
