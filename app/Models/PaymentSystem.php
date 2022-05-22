<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentSystem
 *
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSystem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentSystem extends Model
{
    use HasFactory;
}
