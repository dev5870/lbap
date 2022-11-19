<?php

namespace Tests\Unit\Console\Commands;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckNewPaymentTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    private function resetAddresses(): void
    {
        $addresses = Address::whereNotNull('user_id')->get();

        $addresses->each(function (Address $address) {
            $address->update(['user_id' => null]);
        });
    }

    /**
     * @description Check new payment
     * @return void
     */
    public function test_check_new_payment(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->resetAddresses();

        /** @var Address $address */
        $address = Address::factory()->create(['user_id' => $user->id]);

        Http::fake([config('services.transaction_provider.chain_so') . '*' => Http::response([
            'status' => 'success',
            'data' => [
                'network' => 'DOGE',
                'address' => $address->address,
                'txs' => [
                    [
                        'txid' => $this->faker->uuid,
                        'output_no' => 0,
                        'script_asm' => 'OP_DUP OP_HASH160 1b58992e3aef2070ffdf2ec47098b2154e4f3447 OP_EQUALVERIFY OP_CHECKSIG',
                        'script_hex' => '76a9141b58992e3aef2070ffdf2ec47098b2154e4f344788ac',
                        'value' => '113.82311680',
                        'confirmations' => 150115,
                        'time' => 1658934134,
                    ]
                ]
            ]
        ])]);

        $this->artisan('check:new-payment')->assertOk();
    }
}
