<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Activitylog
 *
 * @property integer $id
 * @property string $body
 * @property string $permalink
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Activitylog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activitylog whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activitylog wherePermalink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activitylog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activitylog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activitylog whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Activitylog extends Model
{
    //
}
