<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\UserReferral
 *
 * @property int $id
 * @property int $user_id
 * @property int $referral_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral filter(\App\Http\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral whereReferralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReferral whereUserId($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\UserReferralFactory factory(...$parameters)
 */
class UserReferral extends Model
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
        'referral_id',
    ];

    public $sortable = [
        'id',
        'user_id',
        'referral_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
