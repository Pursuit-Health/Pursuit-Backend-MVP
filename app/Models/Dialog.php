<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 18:07
 */

namespace App\Models;


use App\Models\Contracts\DialogContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dialog
 *
 * @property int $id
 * @property int $user_id1
 * @property int $user_id2
 * @property string $dialog_uid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin Builder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dialog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dialog whereDialogUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dialog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dialog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dialog whereUserId1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dialog whereUserId2($value)
 */
class Dialog extends Model
{
    protected $fillable = [
        DialogContract::USER_ID1,
        DialogContract::USER_ID2,
        DialogContract::DIALOG_UID,
    ];
}