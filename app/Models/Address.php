<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Address extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'address',
        'payment_system_id',
    ];

    public $sortable = [
        'id',
        'created_at',
    ];

    public function paymentSystem(): HasOne
    {
        return $this->hasOne(PaymentSystem::class, 'id', 'payment_system_id');
    }
}
