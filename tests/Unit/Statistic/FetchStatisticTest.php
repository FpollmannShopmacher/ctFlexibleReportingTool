<?php

namespace Tests\Unit\Statistic;

use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class FetchStatisticTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function statistic_page_can_be_fetched_with_mocked_service()
    {
        // Arrange: User mit Berechtigungen erstellen
        $user = User::factory()->create([
            'user_rights' => 'order-count,order-sales,customer-count',
        ]);

        // Mock für den StatisticsService erstellen
        $mockedStatisticsService = \Mockery::mock(StatisticsService::class);
        $mockedStatisticsService
            ->shouldReceive('fetchStatistic')
            ->once()
            ->andReturn([
                'orderSales' => ['day' => '1000€', 'week' => '7000€'],
                'orderCounts' => ['day' => 5, 'week' => 34],
                'customerCounts' => ['day' => 3, 'week' => 20],
                'userRights' => $user->user_rights,
            ]);

        // Mock in Laravel-Container injizieren
        $this->app->instance(StatisticsService::class, $mockedStatisticsService);

        // Act: Route mit Auth-User aufrufen
        $response = $this
            ->actingAs($user)
            ->get('/dashboard/fetch-statistic?period-day=on&period-week=on&data-order-count=on&data-order-sales=on&data-customer-count=on');

        // Assert: HTTP 200 und erwartete Daten sichtbar
        $response->assertStatus(200);

        // Sicherstellen, dass bestimmte Testdaten im View enthalten sind
        $response->assertSee('1000€');
        $response->assertSee('orderSales');
        $response->assertSee('orderCounts');
        $response->assertSee('customerCounts');
    }
}
