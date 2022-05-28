<?php

namespace App\Dto;

use App\Models\Payment;

class TransactionCreateDto
{
    public Payment $payment;
}
