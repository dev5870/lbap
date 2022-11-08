<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
 * @property string|null $about
 * @property string|null $skill
 * @property string|null $city
 * @property string|null $telegram
 * @property int|null $login_notify
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereLoginNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereSkill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserParam whereTelegram($value)
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

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
