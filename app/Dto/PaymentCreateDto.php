<?php
declare(strict_types=1);

namespace App\Dto;

use App\Enums\PaymentStatus;
use App\Models\User;
use Illuminate\Support\Carbon;

class PaymentCreateDto
{
    public User $user;
    public ?User $userInitiator = null;
    public string $fullAmount;
    public int $type;
    public int $method;
    public ?int $parentId = null;
    public ?string $txid = null;
    public ?string $address = null;
    public int $status = PaymentStatus::CREATE;
    public ?Carbon $paidAt = null;
}
