<?php

namespace App\Services\Admin;

use App\Models\TestSession;
use App\Models\User;
use App\UserRole;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getAllUsers(?string $search = null): LengthAwarePaginator
    {
        return User::query()
            ->where('role', UserRole::USER)
            ->when($search, function ($query, string $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
    }

    public function getUserStats(User $user): array
    {
        $stats = $user->testSessions()
            ->completed()
            ->selectRaw('
                COUNT(*) as total,
                AVG(correct_count * 100.0 / total_questions) as avg_score,
                MAX(correct_count * 100.0 / total_questions) as best_score,
                MAX(completed_at) as last_activity
            ')
            ->first();

        return [
            'total' => (int) ($stats->total ?? 0),
            'avg_score' => $stats->avg_score !== null ? round((float) $stats->avg_score, 1) : null,
            'best_score' => $stats->best_score !== null ? round((float) $stats->best_score, 1) : null,
            'last_activity' => $stats->last_activity ? \Carbon\Carbon::parse($stats->last_activity) : null,
        ];
    }

    public function getUserSessions(User $user): LengthAwarePaginator
    {
        return $user->testSessions()
            ->with('category')
            ->orderBy('started_at', 'desc')
            ->paginate(20);
    }

    public function deleteUser(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->tokens()->delete();
            $user->delete();
        });
    }
}
