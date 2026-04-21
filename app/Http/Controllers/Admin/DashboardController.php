<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StaticService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly StaticService $staticService,
    )
    {}

    public function index()
    {
        $stats = $this->staticService->getDashboardStats();
        return view('admin.dashboard.index', compact('stats'));
    }
}
