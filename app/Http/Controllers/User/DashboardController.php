<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Web\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $stats = $this->dashboardService->getUserStats();
 
        // Filter parametrlarini requestdan olamiz
        // Agar parametr bo'lmasa — default qiymat ishlatiladi
        $filters = [
            'type'   => $request->get('type', 'all'),    // all | random | category
            'status' => $request->get('status', 'all'),  // all | passed | failed | practice
            'sort'   => $request->get('sort', 'newest'), // newest | oldest
        ];
 
        // Filtrlangan sessiyalarni alohida olamiz
        $stats['recentSessions'] = $this->dashboardService->getFilteredSessions($filters);
 
        return view('user.dashboard', compact('stats', 'filters'));

    }
}