<?php

namespace App\Dto;

use App\Models\Payment;

class PaymentUpdateDto
{
    public Payment $payment;
    public int $status;
}
