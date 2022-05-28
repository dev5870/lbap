<?php

namespace App\Dto;

use App\Models\User;

class PaymentCreateDto
{
    public User $user;
    public float $fullAmount;
    public string $type;
}
