<?php

namespace Tests\Unit\Console;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class KernelTest extends TestCase
{
    use WithFaker;

    public function test_run_schedule()
    {
        Event::fake();
        $this->travelTo(now()->startOfWeek()->setHour(9)->setMinute(30));

        $this->artisan('schedule:run');

        Event::assertDispatched(ScheduledTaskFinished::class, function ($event) {
            return str_contains($event->task->command, 'check:free-address');
        });

        Event::assertDispatched(ScheduledTaskFinished::class, function ($event) {
            return str_contains($event->task->command, 'check:diff-user-balance');
        });

        Event::assertDispatched(ScheduledTaskFinished::class, function ($event) {
            return str_contains($event->task->command, 'check:new-payment');
        });
    }
}
