<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property int $status
 * @property int $payment_type_id
 * @property string $full_amount
 * @property string $amount
 * @property string $commission_amount
 * @property int $parent_id
 * @property string|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|Payment filter(\App\Http\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereFullAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $admin_id
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAdminId($value)
 * @property-read \App\Models\User|null $user
 * @property int $method
 * @property string $description
 * @property-read \App\Models\PaymentType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @property string|null $txid
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTxid($value)
 * @method static \Database\Factories\PaymentFactory factory(...$parameters)
 */
class Payment extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable;

    protected $fillable = [
        'user_id',
        'admin_id',
        'address_id',
        'status',
        'payment_type_id',
        'method',
        'full_amount',
        'amount',
        'commission_amount',
        'description',
        'txid',
        'parent_id',
        'paid_at',
    ];

    public $sortable = [
        'id',
        'created_at',
        'paid_at',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }
}
