<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Changelog
 *
 * @property integer $id
 * @property string $table
 * @property string $col_name
 * @property string $old_val
 * @property string $new_val
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereTable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereColName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereOldVal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereNewVal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Changelog whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Changelog extends Model
{
    //
}
