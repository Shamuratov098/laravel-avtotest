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

    public function index()
    {
        // Service'dan barcha hisob-kitoblarni olamiz
        $stats = $this->dashboardService->getUserStats();
        
        // Blade-ga aynan "stats" nomi bilan jo'natamiz
        return view('user.dashboard', compact('stats')); 
        // (Eslatma: agar faylingiz to'g'ridan-to'g'ri views/dashboard.blade.php da bo'lsa, view('dashboard') qilasiz)
    }
}