<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTelegram
 *
 * @property int $id
 * @property int $user_id
 * @property int $chat_id
 * @property string $username
 * @property string|null $firstName
 * @property string|null $lastName
 * @property string|null $languageCode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTelegram whereUsername($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\UserTelegramFactory factory(...$parameters)
 */
class UserTelegram extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
        'username',
        'firstName',
        'lastName',
        'languageCode',
    ];
}
