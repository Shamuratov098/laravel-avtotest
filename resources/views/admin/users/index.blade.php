@extends('admin.layouts.app')

@section('title', 'FOYDALANUVCHILAR')

@section('content')

    <!-- Page Header: count + search -->
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap;">
        <div style="font-size:14px; color:#637381;">
            @if(request('search'))
                Topildi: <strong style="color:#1C2434;">{{ $users->total() }}</strong>
            @else
                Jami: <strong style="color:#1C2434;">{{ $users->total() }}</strong> foydalanuvchi
            @endif
        </div>

        <form method="GET" action="{{ route('admin.users.index') }}"
              style="display:flex; align-items:center; gap:8px;">
            <div style="display:flex; align-items:center; gap:8px; background:#fff; border:1px solid #E8E8E8; border-radius:8px; padding:8px 14px; width:280px;">
                <svg width="16" height="16" fill="none" stroke="#8899A8" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Ism, email yoki telefon..."
                       style="border:none; background:none; outline:none; font-size:13px; color:#1C2434; width:100%;">
            </div>
            <button type="submit"
                    style="padding:9px 18px; background:#5750F1; color:#fff; border:none; border-radius:8px; cursor:pointer; font-size:13px; font-weight:600;">
                Qidirish
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}"
                   title="Qidiruvni tozalash"
                   style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#FEF2F2; color:#DC2626; border-radius:8px; text-decoration:none; font-size:16px; font-weight:600;">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div
        style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden;">

        <!-- Table -->
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr style="background:#F7F9FC; border-bottom:1px solid #F3F4F6;">
                    <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        №
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Ism
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Email
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Telefon
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Ro'yxatdan o'tgan
                    </th>
                    <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Amallar
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr style="border-top:1px solid #F3F4F6; transition:background .15s;"
                        onmouseover="this.style.background='#F7F9FC'" onmouseout="this.style.background='#fff'">
                        <!-- № -->
                        <td style="padding:14px 24px;">
                            <span style="font-size:13px; font-weight:600; color:#1C2434;">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </span>
                        </td>

                        <!-- Ism -->
                        <td style="padding:14px 16px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; min-width:32px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                    <span style="font-size:13px; font-weight:600; color:#5750F1;">
                                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span style="font-size:13px; font-weight:600; color:#1C2434;">{{ $user->name }}</span>
                            </div>
                        </td>

                        <!-- Email -->
                        <td style="padding:14px 16px; font-size:13px; color:#637381;">{{ $user->email }}</td>

                        <!-- Telefon -->
                        <td style="padding:14px 16px;">
                            <span style="font-size:12px; color:#637381; background:#F7F9FC; padding:4px 10px; border-radius:6px; font-family:monospace;">
                                {{ $user->phone ?? '—' }}
                            </span>
                        </td>

                        <!-- Ro'yxatdan o'tgan -->
                        <td style="padding:14px 16px; font-size:12px; color:#8899A8;">
                            {{ $user->created_at->format('d M, Y H:i') }}
                        </td>

                        <!-- Amallar -->
                        <td style="padding:14px 24px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#EEF2FF; color:#5750F1; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600; transition:background .2s;"
                                   onmouseover="this.style.background='#dde4ff'"
                                   onmouseout="this.style.background='#EEF2FF'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ko'rish
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Rostdan ham ushbu foydalanuvchini o\'chirmoqchimisiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#FEF2F2; color:#DC2626; border-radius:6px; border:none; cursor:pointer; font-size:12px; font-weight:600; transition:background .2s;"
                                            onmouseover="this.style.background='#fee2e2'"
                                            onmouseout="this.style.background='#FEF2F2'">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        O'chirish
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:56px; text-align:center;">
                            <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                                <div style="width:56px; height:56px; background:#F7F9FC; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="28" height="28" fill="none" stroke="#8899A8" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                @if(request('search'))
                                    <p style="font-size:15px; font-weight:600; color:#1C2434; margin:0;">
                                        «{{ request('search') }}» bo'yicha foydalanuvchi topilmadi
                                    </p>
                                    <a href="{{ route('admin.users.index') }}"
                                       style="margin-top:4px; display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:#5750F1; color:#fff; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
                                        Qidiruvni tozalash
                                    </a>
                                @else
                                    <p style="font-size:15px; font-weight:600; color:#1C2434; margin:0;">
                                        Hozircha hech kim ro'yxatdan o'tmagan
                                    </p>
                                    <p style="font-size:13px; color:#8899A8; margin:0;">
                                        Foydalanuvchilar mobil ilova orqali ro'yxatdan o'tadilar
                                    </p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div style="padding:16px 24px; border-top:1px solid #F3F4F6;">
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection
