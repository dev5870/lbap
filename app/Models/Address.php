<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $address
 * @property int|null $user_id
 * @property int $payment_system_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PaymentSystem|null $paymentSystem
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePaymentSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Address filter(\App\Http\Filters\QueryFilter $filter)
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\AddressFactory factory(...$parameters)
 */
class Address extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable;

    protected $fillable = [
        'address',
        'payment_system_id',
        'user_id',
    ];

    public $sortable = [
        'id',
        'created_at',
    ];

    public function paymentSystem(): HasOne
    {
        return $this->hasOne(PaymentSystem::class, 'id', 'payment_system_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
