<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserParam
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $user_uuid
 * @property string|null $username
 * @property string|null $description
 * @property int|null $mfa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereMfa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereUsername($value)
 * @mixin \Eloquent
 */
class UserParam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_uuid',
        'username',
        'description',
        'about',
        'skill',
        'city',
        'telegram',
        'mfa',
        'login_notify',
    ];
}
