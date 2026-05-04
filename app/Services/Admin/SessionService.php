<?php

namespace App\Services\Admin;

use App\Models\TestSession;
use App\TestSessionStatus;
use App\TestSessionType;
use Illuminate\Pagination\LengthAwarePaginator;

class SessionService
{
    public function getAllSessions(array $filters): LengthAwarePaginator
    {
        $status = $filters['status'] ?? TestSessionStatus::COMPLETED->value;
        $type = $filters['type'] ?? null;
        $categoryId = $filters['category_id'] ?? null;
        $search = $filters['search'] ?? null;
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;

        return TestSession::query()
            ->with(['user:id,name,email,phone', 'category:id,name'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($type, fn ($q, $t) => $q->where('type', $t))
            ->when($categoryId, fn ($q, $id) => $q->where('category_id', $id))
            ->when($search, function ($q, string $search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($dateFrom, fn ($q, $d) => $q->whereDate('started_at', '>=', $d))
            ->when($dateTo, fn ($q, $d) => $q->whereDate('started_at', '<=', $d))
            ->orderByDesc('started_at')
            ->paginate(20)
            ->withQueryString();
    }

    public function getSessionWithDetails(TestSession $session): TestSession
    {
        return $session->load([
            'user:id,name,email,phone',
            'category:id,name',
            'results' => fn ($q) => $q->orderBy('id'),
            'results.question:id,category_id,question_text,image_url,correct_answer,explanation',
            'results.question.category:id,name',
            'results.question.answers:id,question_id,option_number,answer_text',
        ]);
    }

    public function deleteSession(TestSession $session): void
    {
        $session->delete();
    }
}