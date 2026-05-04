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
        $trends = $this->staticService->getTrendStats();
        $topCategories = $this->staticService->getTopCategories();
        $recentSessions = $this->staticService->getRecentSessions();
        $passRate = $this->staticService->getPassRate();
        $dailyTests = $this->staticService->getDailyTests();
        $monthlyTests = $this->staticService->getMonthlyTests();
        $yearlyTests = $this->staticService->getYearlyTests();

        return view('admin.dashboard.index', compact(
            'stats',
            'trends',
            'topCategories',
            'recentSessions',
            'passRate',
            'dailyTests',
            'monthlyTests',
            'yearlyTests',
        ));
    }
}
