<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTelegramCode
 *
 * @property int $id
 * @property int $user_id
 * @property int $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegramCode whereUserId($value)
 * @mixin \Eloquent
 */
class UserTelegramCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
    ];
}
