<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckFreeAddressTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * @description Check free address
     * @return void
     */
    public function test_check_free_address(): void
    {
        $this->artisan('check:free-address')->assertOk();
    }
}
