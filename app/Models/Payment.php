<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Traits\Filterable;
use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use function Sodium\add;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property int $status
 * @property int $type
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
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable;

    protected $fillable = [
        'user_id',
        'address_id',
        'status',
        'type',
        'full_amount',
        'amount',
        'commission_amount',
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

            if (
                ($model->type == PaymentType::TOP_UP) &&
                !$model->address &&
                PaymentService::getAddress()
            ) {

                DB::beginTransaction();

                $address = PaymentService::getAddress();
                $address->user_id = $model->user_id;

                if ($address->save()) {
                    $model->address_id = $address->id;
                    DB::commit();
                } else {
                    DB::rollBack();
                }

            }
            $model->status = PaymentStatus::CREATE;
            $model->save();
        });
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
