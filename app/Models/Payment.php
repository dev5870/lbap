<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Payment extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable;

    protected $fillable = [
        'user_id',
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
            $model->status = PaymentStatus::CREATE;
            $model->save();
        });
    }
}
