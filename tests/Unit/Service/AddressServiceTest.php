<?php
declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Models\Address;
use App\Models\SystemNotice;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @description Check free address
     * @return void
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function test_check_free_address(): void
    {
        $addresses = Address::whereNull('user_id')->count();

        if ($addresses <= config('address.minimal')) {
            Address::factory(config('address.minimal') + 1)->create();
        }

        AddressService::isFreeAddressExists();
        $systemNotice = SystemNotice::where('title', '=', 'Attention')
            ->where('description', 'like', 'Available address count: %')
            ->where('created_at', '=', now())
            ->exists();

        $this->assertFalse($systemNotice);
    }

    /**
     * @description Check free address and notice if not available free address
     * @return void
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function test_check_free_address_notice(): void
    {
        $addresses = Address::whereNull('user_id')->get();

        foreach ($addresses as $address) {
            $address->user_id = 1;
            $address->save();
        }

        AddressService::isFreeAddressExists();
        $systemNotice = SystemNotice::where('title', '=', 'Attention')
            ->where('description', 'like', 'Available address count: %')
            ->exists();

        $this->assertTrue($systemNotice);
    }

    /**
     * @description Check correct count free addresses
     * @return void
     */
    public function test_count_free_address(): void
    {
        $addresses = Address::whereNull('user_id')->count();
        $serviceCount = AddressService::countFreeAddress();

        $this->assertTrue($addresses === $serviceCount);
    }

    /**
     * @description Can get free address
     * @return void
     */
    public function test_get_free_address(): void
    {
        $addresses = Address::whereNull('user_id')->count();

        if ($addresses <= config('address.minimal')) {
            Address::factory(config('address.minimal') + 1)->create();
        }

        $address = AddressService::getFreeAddress();

        $this->assertInstanceOf(Address::class, $address);
    }
}
