<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\UserUserAgent
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $ip
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent filter(\App\Http\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserUserAgent whereUserId($value)
 * @mixin \Eloquent
 */
class UserUserAgent extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];

    public $sortable = [
        'user_id',
        'created_at',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
