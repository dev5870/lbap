<?php
declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Models\PaymentType;
use App\Services\CommissionService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommissionServiceTest extends TestCase
{
    use WithFaker;

    public function test_get_percent_commission(): void
    {
        $service = new CommissionService();

        $this->assertEquals('0', $service->getPercentCommission(10));
    }

    public function test_get_referral_commission(): void
    {
        $service = new CommissionService();

        $percent = PaymentType::whereName('referral_commission')->first();
        $this->assertEquals($percent->commission, $service->getReferralCommission());
    }

    public function test_get_referral_commission_negative(): void
    {
        $service = new CommissionService();

        $percent = PaymentType::whereName('referral_commission')->first();
        $percent->name = 'test';
        $percent->save();

        $this->assertEquals(config('balance.default_commission'), $service->getReferralCommission());

        $percent->name = 'referral_commission';
        $percent->save();
    }
}
