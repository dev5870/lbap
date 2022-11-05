<?php
declare(strict_types=1);

namespace App\Dto;

use App\Models\Payment;

class TransactionCreateDto
{
    public Payment $payment;
}
