<?php

namespace App\Dto;

use App\Models\User;

class PaymentCreateDto
{
    public User $user;
    public ?User $userInitiator = null;
    public string $fullAmount;
    public string $type;
    public string $method;
    public ?int $parentId = null;
}
