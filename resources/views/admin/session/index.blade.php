@extends('admin.layouts.app')

@section('title', 'YECHILGAN TESTLAR')

@section('content')

    @php
        use App\TestSessionStatus;
        use App\TestSessionType;

        $statusValue = $filters['status'] ?? TestSessionStatus::COMPLETED->value;
        $typeValue = $filters['type'] ?? '';
        $categoryValue = $filters['category_id'] ?? '';
        $searchValue = $filters['search'] ?? '';
        $dateFromValue = $filters['date_from'] ?? '';
        $dateToValue = $filters['date_to'] ?? '';
        $hasFilter = $statusValue !== TestSessionStatus::COMPLETED->value
            || $typeValue !== '' || $categoryValue !== '' || $searchValue !== ''
            || $dateFromValue !== '' || $dateToValue !== '';
    @endphp

    <!-- Page Header: count -->
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:20px; flex-wrap:wrap;">
        <div style="font-size:14px; color:#637381;">
            @if($hasFilter)
                Topildi: <strong style="color:#1C2434;">{{ $sessions->total() }}</strong>
            @else
                Jami: <strong style="color:#1C2434;">{{ $sessions->total() }}</strong> sessiya
            @endif
        </div>
        @if($hasFilter)
            <a href="{{ route('admin.sessions.index') }}"
               style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; background:#FEF2F2; color:#DC2626; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
                Filterlarni tozalash ✕
            </a>
        @endif
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.sessions.index') }}"
          style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:18px 20px; margin-bottom:20px;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px;">

            <!-- Status -->
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.04em; margin-bottom:5px;">Status</label>
                <select name="status"
                        style="width:100%; padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:8px; font-size:13px; color:#1C2434; outline:none; background:#fff; box-sizing:border-box;">
                    <option value="{{ TestSessionStatus::COMPLETED->value }}" {{ $statusValue === TestSessionStatus::COMPLETED->value ? 'selected' : '' }}>Tugatilgan</option>
                    <option value="{{ TestSessionStatus::IN_PROGRESS->value }}" {{ $statusValue === TestSessionStatus::IN_PROGRESS->value ? 'selected' : '' }}>Jarayonda</option>
                    <option value="all" {{ $statusValue === 'all' ? 'selected' : '' }}>Hammasi</option>
                </select>
            </div>

            <!-- Type -->
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.04em; margin-bottom:5px;">Test turi</label>
                <select name="type"
                        style="width:100%; padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:8px; font-size:13px; color:#1C2434; outline:none; background:#fff; box-sizing:border-box;">
                    <option value="">Hammasi</option>
                    <option value="{{ TestSessionType::CATEGORY->value }}" {{ $typeValue === TestSessionType::CATEGORY->value ? 'selected' : '' }}>Kategoriya</option>
                    <option value="{{ TestSessionType::RANDOM->value }}" {{ $typeValue === TestSessionType::RANDOM->value ? 'selected' : '' }}>Tasodifiy</option>
                </select>
            </div>

            <!-- Category -->
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.04em; margin-bottom:5px;">Kategoriya</label>
                <select name="category_id"
                        style="width:100%; padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:8px; font-size:13px; color:#1C2434; outline:none; background:#fff; box-sizing:border-box;">
                    <option value="">Hammasi</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string) $categoryValue === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search -->
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.04em; margin-bottom:5px;">Foydalanuvchi</label>
                <input type="text" name="search" value="{{ $searchValue }}" placeholder="Ism / email / telefon"
                       style="width:100%; padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box;">
            </div>

            <!-- Date from -->
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.04em; margin-bottom:5px;">Sanadan</label>
                <input type="date" name="date_from" value="{{ $dateFromValue }}"
                       style="width:100%; padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box;">
            </div>

            <!-- Date to -->
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.04em; margin-bottom:5px;">Sanagacha</label>
                <input type="date" name="date_to" value="{{ $dateToValue }}"
                       style="width:100%; padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box;">
            </div>
        </div>

        <div style="display:flex; gap:8px; margin-top:14px;">
            <button type="submit"
                    style="padding:9px 22px; background:#5750F1; color:#fff; border:none; border-radius:8px; cursor:pointer; font-size:13px; font-weight:600;">
                Qo'llash
            </button>
        </div>
    </form>

    <!-- Table Card -->
    <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden;">

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr style="background:#F7F9FC; border-bottom:1px solid #F3F4F6;">
                    <th style="padding:12px 20px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">№</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Foydalanuvchi</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Test turi</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Kategoriya</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Status</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Natija</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Davomiylik</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Sana</th>
                    <th style="padding:12px 20px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">Amallar</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sessions as $session)
                    @php
                        $isCompleted = $session->status === TestSessionStatus::COMPLETED;
                        $total = max((int) $session->total_questions, 1);
                        $correct = (int) $session->correct_count;
                        $percent = $isCompleted ? (int) round(($correct / $total) * 100) : null;
                        $passed = $isCompleted && $percent >= 90;
                        $isRandom = $session->type === TestSessionType::RANDOM;
                    @endphp
                    <tr style="border-top:1px solid #F3F4F6; transition:background .15s;"
                        onmouseover="this.style.background='#F7F9FC'" onmouseout="this.style.background='#fff'">

                        <!-- № -->
                        <td style="padding:14px 20px;">
                            <span style="font-size:13px; font-weight:600; color:#1C2434;">
                                {{ ($sessions->currentPage() - 1) * $sessions->perPage() + $loop->iteration }}
                            </span>
                        </td>

                        <!-- User -->
                        <td style="padding:14px 16px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; min-width:32px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                    <span style="font-size:13px; font-weight:600; color:#5750F1;">
                                        {{ strtoupper(mb_substr($session->user->name ?? '?', 0, 1)) }}
                                    </span>
                                </div>
                                <span style="font-size:13px; font-weight:600; color:#1C2434;">{{ $session->user->name ?? '—' }}</span>
                            </div>
                        </td>

                        <!-- Type -->
                        <td style="padding:14px 16px;">
                            @if($isRandom)
                                <span style="display:inline-block; padding:4px 10px; background:#FEF3C7; color:#92400E; border-radius:6px; font-size:11px; font-weight:600;">Tasodifiy</span>
                            @else
                                <span style="display:inline-block; padding:4px 10px; background:#EEF2FF; color:#5750F1; border-radius:6px; font-size:11px; font-weight:600;">Kategoriya</span>
                            @endif
                        </td>

                        <!-- Category -->
                        <td style="padding:14px 16px; font-size:13px; color:#637381;">
                            {{ $isRandom ? '—' : ($session->category->name ?? '—') }}
                        </td>

                        <!-- Status -->
                        <td style="padding:14px 16px;">
                            @if($isCompleted)
                                <span style="display:inline-block; padding:4px 10px; background:#F0FDF4; color:#15803D; border-radius:6px; font-size:11px; font-weight:600;">Tugatilgan</span>
                            @else
                                <span style="display:inline-block; padding:4px 10px; background:#FEF3C7; color:#92400E; border-radius:6px; font-size:11px; font-weight:600;">Jarayonda</span>
                            @endif
                        </td>

                        <!-- Result -->
                        <td style="padding:14px 16px;">
                            @if($isCompleted)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:13px; font-weight:600; color:#1C2434;">{{ $correct }}/{{ $total }}</span>
                                    <span style="font-size:11px; color:#637381;">({{ $percent }}%)</span>
                                    @if($passed)
                                        <span style="display:inline-block; padding:2px 8px; background:#F0FDF4; color:#15803D; border-radius:4px; font-size:10px; font-weight:700;">O'TDI</span>
                                    @else
                                        <span style="display:inline-block; padding:2px 8px; background:#FEF2F2; color:#DC2626; border-radius:4px; font-size:10px; font-weight:700;">O'TMADI</span>
                                    @endif
                                </div>
                            @else
                                <span style="font-size:12px; color:#8899A8;">—</span>
                            @endif
                        </td>

                        <!-- Duration -->
                        <td style="padding:14px 16px; font-size:12px; color:#637381;">
                            {{ $session->formattedDuration() ?? '—' }}
                        </td>

                        <!-- Date -->
                        <td style="padding:14px 16px;">
                            @if($isCompleted && $session->completed_at)
                                <span style="font-size:12px; color:#8899A8;">{{ $session->completed_at->format('d M, Y H:i') }}</span>
                            @else
                                <div style="display:flex; flex-direction:column; gap:2px;">
                                    <span style="font-size:12px; color:#8899A8;">{{ $session->started_at->format('d M, Y H:i') }}</span>
                                    <span style="font-size:10px; color:#B6BFC9;">boshlangan</span>
                                </div>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td style="padding:14px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('admin.sessions.show', $session) }}"
                                   style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#EEF2FF; color:#5750F1; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ko'rish
                                </a>

                                <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST"
                                      onsubmit="return confirm('Rostdan ham ushbu sessiyani o\'chirmoqchimisiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#FEF2F2; color:#DC2626; border-radius:6px; border:none; cursor:pointer; font-size:12px; font-weight:600;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        O'chirish
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding:56px; text-align:center;">
                            <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                                <div style="width:56px; height:56px; background:#F7F9FC; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="28" height="28" fill="none" stroke="#8899A8" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p style="font-size:15px; font-weight:600; color:#1C2434; margin:0;">
                                    @if($hasFilter)
                                        Filter bo'yicha sessiya topilmadi
                                    @else
                                        Hozircha sessiyalar yo'q
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #F3F4F6;">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>

@endsection
