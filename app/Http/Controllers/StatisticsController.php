<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    private StatisticsService $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function viewStatistic(Request $request)
    {
        $data = $this->statisticsService->fetchStatistic($request);

        return view('dashboard', $data);
    }

    public function download(Request $request, $type)
    {
        return $this->statisticsService->downloadStatistics($request, $type);
    }
}
