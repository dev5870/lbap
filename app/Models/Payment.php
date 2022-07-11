<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Traits\Filterable;
use App\Services\AddressService;
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
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $admin_id
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAdminId($value)
 * @property-read \App\Models\User|null $user
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
        'paid_at',
    ];

    public $sortable = [
        'id',
        'created_at',
        'paid_at',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {

            if (!$model->user->address?->exists()) {

                if ($address = AddressService::getAddress()) {
                    $address->user_id = $model->user_id;
                }

                if ($address->save()) {
                    $address->refresh();
                    $model->address_id = $address->id;
                }
            } elseif ($model->user->address?->exists()) {
                $model->address_id = $model->user->address->id;
            }

            $model->status = PaymentStatus::CREATE;
            $model->save();
        });
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }
}
