<?php

namespace App\Dto;

use App\Models\Payment;

class PaymentCreateDto
{
    public int $userId;
    public float $fullAmount;
    public string $type;
}
