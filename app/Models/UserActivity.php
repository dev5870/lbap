<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserActivity
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon|null $last_activity
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereUserId($value)
 * @mixin \Eloquent
 */
class UserActivity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'last_activity' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'user_id',
        'last_activity',
    ];
}
