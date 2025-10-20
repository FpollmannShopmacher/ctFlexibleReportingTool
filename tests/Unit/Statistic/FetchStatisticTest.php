<?php

namespace Tests\Unit\Statistic;

use App\Models\User;
use Tests\TestCase;


class FetchStatisticTest extends TestCase
{

    public function test_statistic_can_be_fetched(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/fetch-statistic?period-day=on&period-week=on&period-month=on&period-year=on&data-order-count=on&data-order-sales=on&data-customer-count=on');

        $response->assertStatus(200);
    }
}
