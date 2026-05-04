<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\TestSession;
use App\Services\Admin\SessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function __construct(
        private readonly SessionService $sessionService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'type', 'category_id', 'search', 'date_from', 'date_to']);
        $sessions = $this->sessionService->getAllSessions($filters);
        $categories = Category::orderBy('order')->get(['id', 'name']);

        return $this->view('session.index', compact('sessions', 'categories', 'filters'));
    }

    public function show(TestSession $session): View
    {
        $session = $this->sessionService->getSessionWithDetails($session);

        return $this->view('session.show', compact('session'));
    }

    public function destroy(TestSession $session): RedirectResponse
    {
        $this->sessionService->deleteSession($session);

        return $this->success('admin.sessions.index', 'Sessiya muvaffaqiyatli o\'chirildi!');
    }
}