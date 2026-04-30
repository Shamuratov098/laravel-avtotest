@extends('admin.layouts.app')

@section('title', 'FOYDALANUVCHI: ' . strtoupper($user->name))

@section('content')

    <!-- Top actions: back + delete -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <a href="{{ route('admin.users.index') }}"
           style="display:inline-flex; align-items:center; gap:8px; padding:9px 16px; background:#fff; color:#637381; border:1px solid #E8E8E8; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Ro'yxatga qaytish
        </a>

        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
              onsubmit="return confirm('Rostdan ham ushbu foydalanuvchini o\'chirmoqchimisiz?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    style="display:inline-flex; align-items:center; gap:8px; padding:9px 16px; background:#FEF2F2; color:#DC2626; border:1px solid #FEE2E2; border-radius:8px; cursor:pointer; font-size:13px; font-weight:600;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                O'chirish
            </button>
        </form>
    </div>

    <!-- Profile block -->
    <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:24px; margin-bottom:24px;">
        <div style="display:flex; align-items:center; gap:20px;">
            <div style="width:72px; height:72px; min-width:72px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <span style="font-size:28px; font-weight:700; color:#5750F1;">
                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                </span>
            </div>
            <div style="flex:1; display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 4px;">Ism</p>
                    <p style="font-size:15px; font-weight:600; color:#1C2434; margin:0;">{{ $user->name }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 4px;">Email</p>
                    <p style="font-size:14px; color:#637381; margin:0;">{{ $user->email }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 4px;">Telefon</p>
                    <p style="font-size:14px; color:#637381; margin:0; font-family:monospace;">{{ $user->phone ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 4px;">Ro'yxatdan o'tgan</p>
                    <p style="font-size:14px; color:#637381; margin:0;">{{ $user->created_at->format('d M, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats cards -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
        <!-- Jami testlar -->
        <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:20px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <div style="width:40px; height:40px; background:#EEF2FF; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" fill="none" stroke="#5750F1" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p style="font-size:12px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0;">Jami testlar</p>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0;">{{ $stats['total'] }}</p>
        </div>

        <!-- O'rtacha foiz -->
        <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:20px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <div style="width:40px; height:40px; background:#FEF3C7; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" fill="none" stroke="#D97706" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <p style="font-size:12px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0;">O'rtacha foiz</p>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0;">
                {{ $stats['avg_score'] !== null ? $stats['avg_score'] . '%' : '—' }}
            </p>
        </div>

        <!-- Eng yaxshi natija -->
        <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:20px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <div style="width:40px; height:40px; background:#F0FDF4; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" fill="none" stroke="#16A34A" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <p style="font-size:12px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0;">Eng yaxshi</p>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0;">
                {{ $stats['best_score'] !== null ? $stats['best_score'] . '%' : '—' }}
            </p>
        </div>

        <!-- Oxirgi faollik -->
        <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:20px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <div style="width:40px; height:40px; background:#F3E8FF; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" fill="none" stroke="#9333EA" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p style="font-size:12px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0;">Oxirgi faollik</p>
            </div>
            <p style="font-size:18px; font-weight:700; color:#1C2434; margin:0;">
                {{ $stats['last_activity'] ? $stats['last_activity']->format('d M, Y') : '—' }}
            </p>
            @if($stats['last_activity'])
                <p style="font-size:12px; color:#8899A8; margin:4px 0 0;">{{ $stats['last_activity']->diffForHumans() }}</p>
            @endif
        </div>
    </div>

    <!-- Sessions table -->
    <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden;">
        <div style="padding:16px 24px; border-bottom:1px solid #F3F4F6; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="font-size:14px; font-weight:700; color:#1C2434; margin:0; text-transform:uppercase; letter-spacing:.04em;">
                Test sessiyalari
            </h3>
            <span style="font-size:12px; color:#8899A8;">Jami: {{ $sessions->total() }}</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr style="background:#F7F9FC; border-bottom:1px solid #F3F4F6;">
                    <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Sana
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Kategoriya
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Natija
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Davomiyligi
                    </th>
                    <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Status
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($sessions as $session)
                    @php
                        $isCompleted = $session->status->value === 'completed';
                        $percent = $session->total_questions > 0
                            ? round($session->correct_count * 100 / $session->total_questions)
                            : 0;
                        $duration = $session->formattedDuration();
                    @endphp
                    <tr style="border-top:1px solid #F3F4F6;">
                        <!-- Sana -->
                        <td style="padding:14px 24px; font-size:12px; color:#637381;">
                            {{ $session->started_at->format('d M, Y H:i') }}
                        </td>

                        <!-- Kategoriya -->
                        <td style="padding:14px 16px;">
                            @if($session->category)
                                <span style="font-size:13px; color:#1C2434;">{{ $session->category->name }}</span>
                            @else
                                <span style="font-size:12px; color:#9333EA; background:#F3E8FF; padding:3px 10px; border-radius:6px; font-weight:600;">
                                    Tasodifiy
                                </span>
                            @endif
                        </td>

                        <!-- Natija -->
                        <td style="padding:14px 16px;">
                            @if($isCompleted)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:13px; font-weight:600; color:#1C2434; font-family:monospace;">
                                        {{ $session->correct_count }} / {{ $session->total_questions }}
                                    </span>
                                    <span style="font-size:11px; font-weight:600; padding:3px 8px; border-radius:6px;
                                        {{ $percent >= 70 ? 'background:#F0FDF4; color:#16A34A;' : ($percent >= 50 ? 'background:#FEF3C7; color:#D97706;' : 'background:#FEF2F2; color:#DC2626;') }}">
                                        {{ $percent }}%
                                    </span>
                                </div>
                            @else
                                <span style="font-size:12px; color:#8899A8;">—</span>
                            @endif
                        </td>

                        <!-- Davomiyligi -->
                        <td style="padding:14px 16px; font-size:12px; color:#637381;">
                            {{ $duration ?? '—' }}
                        </td>

                        <!-- Status -->
                        <td style="padding:14px 24px;">
                            @if($isCompleted)
                                <span style="font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px; background:#F0FDF4; color:#16A34A;">
                                    Tugatilgan
                                </span>
                            @else
                                <span style="font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px; background:#FEF3C7; color:#D97706;">
                                    Jarayonda
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:48px; text-align:center;">
                            <p style="font-size:14px; color:#8899A8; margin:0;">Bu foydalanuvchi hali test yechmagan</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
            <div style="padding:16px 24px; border-top:1px solid #F3F4F6;">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>

@endsection
