<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\StaticService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly StaticService $staticService,
    )
    {
    }

    public function index()
    {
        $stats = $this->staticService->getDashboardStats();
        $dailyTests = $this->staticService->getDailyTests();
        $monthlyTests = $this->staticService->getMonthlyTests();
        $yearlyTests = $this->staticService->getYearlyTests();
        return view('admin.dashboard.index', compact(
            'stats',
            'dailyTests',
            'monthlyTests',
            'yearlyTests',
        ));
    }
}
