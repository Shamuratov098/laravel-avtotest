@extends('admin.layouts.app')

@section('title', 'KATEGORIYALAR')

@section('content')

    <!-- Page Header -->
    <div style="display:flex; align-items:center; justify-content:right; margin-bottom:24px;">
        <a href="{{ route('admin.categories.create') }}"
           style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:#5750F1; color:#fff; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; transition:background .2s;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Yangi Kategoriya
        </a>
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
                        TRATIB RAQAMI
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Nomi
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Jami Savollar
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Yaratilgan
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Yangilangan
                    </th>
                    <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Amallar
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr style="border-top:1px solid #F3F4F6; transition:background .15s;"
                        onmouseover="this.style.background='#F7F9FC'" onmouseout="this.style.background='#fff'">
                        <!-- Tartib raqami -->
                        <td style="padding:14px 16px;">
                            <span
                                style="font-size:13px; font-weight:600; color:#1C2434;">{{ $category->order }}</span>
                            <span style="font-size:12px; color:#8899A8; margin-left:2px;"></span>
                        </td>

                        <!-- Nomi -->
                        <td style="padding:14px 16px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span
                                    style="font-size:13px; font-weight:600; color:#1C2434;">{{ $category->name }}</span>
                            </div>
                        </td>

                        <!-- Total Questions -->
                        <td style="padding:14px 16px;">
                            <span
                                style="font-size:12px; color:#637381; background:#F7F9FC; padding:4px 10px; border-radius:6px; font-family:monospace;">{{ $category->total_questions }}</span>
                        </td>

                        <!-- Yaratilgan -->
                        <td style="padding:14px 16px; font-size:12px; color:#8899A8;">{{ $category->created_at->format('d M, Y  h:m') }}</td>

                        <!-- Yangilangan -->
                        <td style="padding:14px 16px; font-size:12px; color:#8899A8;">{{ $category->updated_at->format('d M, Y  H:m') }}</td>

                        <!-- Amallar -->
                        <td style="padding:14px 24px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#EEF2FF; color:#5750F1; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600; transition:background .2s;"
                                   onmouseover="this.style.background='#dde4ff'"
                                   onmouseout="this.style.background='#EEF2FF'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Yangilash
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#FEF2F2; color:#DC2626; border-radius:6px; border:none; cursor:pointer; font-size:12px; font-weight:600; transition:background .2s;"
                                            onmouseover="this.style.background='#fee2e2'"
                                            onmouseout="this.style.background='#FEF2F2'">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
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
                                <div
                                    style="width:56px; height:56px; background:#F7F9FC; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="28" height="28" fill="none" stroke="#8899A8" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                </div>
                                <p style="font-size:15px; font-weight:600; color:#1C2434; margin:0;">Kategoriyalar
                                    topilmadi</p>
                                <p style="font-size:13px; color:#8899A8; margin:0;">Birinchi kategoriyani yarating</p>
                                <a href=""
                                   {{--                                   {{ route('admin.categories.create') }}--}}
                                   style="margin-top:4px; display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:#5750F1; color:#fff; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Yangi Kategoriya
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $categories->links() }}
    </div>

@endsection
