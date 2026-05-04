<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @yield('styles')
</head>
<body style="background:#F7F9FC; min-height:100vh; font-family: sans-serif; margin:0;">

<div style="display:flex; min-height:100vh;">

    <!-- ===================== SIDEBAR ===================== -->
    <aside
        style="width:260px; min-width:260px; background:#fff; border-right:1px solid #E8E8E8; display:flex; flex-direction:column; min-height:100vh; position:sticky; top:0; height:100vh; overflow-y:auto;">

        <!-- Logo -->
        <div style="padding:24px 20px 20px; border-bottom:1px solid #F3F4F6;">
            <a href="{{ route('admin.dashboard') }}"
               style="display:flex; align-items:center; gap:10px; text-decoration:none;">
                <div
                    style="width:40px; height:40px; background:#5750F1; border-radius:12px; display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 12px rgba(87, 80, 241, 0.4); overflow: hidden;">
                    <img src="https://cdn-icons-png.flaticon.com/512/744/744465.png"
                         alt="Car"
                         style="width: 28px; height: 28px; object-fit: contain; filter: brightness(0) invert(1);">
                </div>
                <span style="font-size:18px; font-weight:700; color:#1C2434;">AVTO TEST</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav style="flex:1; padding:20px 12px;">

            <a href="{{ route('admin.dashboard') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; margin-bottom:2px; font-size:14px; font-weight:500; transition:all .2s;
               {{ request()->routeIs('admin.dashboard') ? 'background:rgba(87,80,241,0.07); color:#5750F1;' : 'color:#637381;' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                BOSH SAHIFA
            </a>

            <a href="{{route('admin.categories.index')}}"
               style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; margin-bottom:2px; font-size:14px; font-weight:500;
               {{ request()->routeIs('admin.categories.*') ? 'background:rgba(87,80,241,0.07); color:#5750F1;' : 'color:#637381;' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                KATEGORIYALAR
            </a>

            {{--<a href=""
               style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; margin-bottom:2px; font-size:14px; font-weight:500;
               {{ request()->routeIs('admin.brands.*') ? 'background:rgba(87,80,241,0.07); color:#5750F1;' : 'color:#637381;' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Brendlar
            </a>--}}

            <a href="{{route('admin.questions.index')}}"
               style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; margin-bottom:2px; font-size:14px; font-weight:500;
               {{ request()->routeIs('admin.questions.*') ? 'background:rgba(87,80,241,0.07); color:#5750F1;' : 'color:#637381;' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                TEST SAVOLLAR
            </a>

            <a href="{{ route('admin.sessions.index') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; margin-bottom:2px; font-size:14px; font-weight:500;
               {{ request()->routeIs('admin.sessions.*') ? 'background:rgba(87,80,241,0.07); color:#5750F1;' : 'color:#637381;' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                YECHILGAN TESTLAR
            </a>

            <a href="{{ route('admin.users.index') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; margin-bottom:2px; font-size:14px; font-weight:500;
               {{ request()->routeIs('admin.users.*') ? 'background:rgba(87,80,241,0.07); color:#5750F1;' : 'color:#637381;' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                FOYDALANUVCHILAR
            </a>

        </nav>

        <!-- User + Logout -->
        <div style="padding:16px 12px; border-top:1px solid #F3F4F6;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px; padding:0 8px;">
                <div
                    style="width:36px; height:36px; min-width:36px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                    <span
                        style="font-size:14px; font-weight:600; color:#5750F1;">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
                <div style="overflow:hidden;">
                    <p style="font-size:13px; font-weight:600; color:#1C2434; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p style="font-size:11px; color:#8899A8; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        style="width:100%; display:flex; align-items:center; gap:8px; padding:9px 12px; background:none; border:1px solid #FEE2E2; border-radius:8px; cursor:pointer; font-size:13px; font-weight:500; color:#EF4444;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Chiqish
                </button>
            </form>
        </div>

    </aside>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div style="flex:1; display:flex; flex-direction:column; min-width:0; overflow:hidden;">

        <!-- Header -->
        <header
            style="background:#fff; border-bottom:1px solid #E8E8E8; padding:14px 32px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:30;">
            <div>
                <h2 style="font-size:18px; font-weight:700; color:#1C2434; margin:0;">@yield('title', 'Dashboard')</h2>
                <p style="font-size:12px; color:#8899A8; margin:2px 0 0;">{{ now()->format('d F, Y') }}</p>
            </div>

            <div style="display:flex; align-items:center; gap:12px;">
                <!-- Search -->
                <div
                    style="display:flex; align-items:center; gap:8px; background:#F7F9FC; border:1px solid #E8E8E8; border-radius:8px; padding:8px 14px; width:220px;">
                    <svg width="16" height="16" fill="none" stroke="#8899A8" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Qidirish..."
                           style="border:none; background:none; outline:none; font-size:13px; color:#637381; width:100%;">
                </div>

                <!-- Notification -->
                <div style="position:relative;">
                    <button
                        style="width:38px; height:38px; background:#F7F9FC; border:1px solid #E8E8E8; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer;">
                        <svg width="18" height="18" fill="none" stroke="#637381" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span
                            style="position:absolute; top:8px; right:8px; width:7px; height:7px; background:#EF4444; border-radius:50%; border:2px solid #fff;"></span>
                    </button>
                </div>

                <!-- Avatar -->
                <div
                    style="width:38px; height:38px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:2px solid #E8E8E8;">
                    <span
                        style="font-size:15px; font-weight:700; color:#5750F1;">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div style="margin:20px 32px 0;">
                <div
                    style="background:#F0FDF4; border-left:4px solid #22C55E; padding:12px 16px; border-radius:0 8px 8px 0; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <svg width="18" height="18" fill="none" stroke="#22C55E" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span style="font-size:13px; color:#166534;">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()"
                            style="background:none; border:none; cursor:pointer; color:#22C55E; font-size:16px;">✕
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div style="margin:20px 32px 0;">
                <div
                    style="background:#FEF2F2; border-left:4px solid #EF4444; padding:12px 16px; border-radius:0 8px 8px 0; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <svg width="18" height="18" fill="none" stroke="#EF4444" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span style="font-size:13px; color:#991B1B;">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()"
                            style="background:none; border:none; cursor:pointer; color:#EF4444; font-size:16px;">✕
                    </button>
                </div>
            </div>
        @endif

        <!-- Content -->
        <main style="flex:1; padding:28px 32px;">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer style="padding:14px 32px; border-top:1px solid #E8E8E8; background:#fff;">
            <p style="font-size:12px; color:#8899A8; margin:0;">&copy; {{ date('Y') }} {{ config('app.name') }}. Barcha
                huquqlar himoyalangan.</p>
        </footer>

    </div>
</div>

@yield('scripts')
</body>
</html>
