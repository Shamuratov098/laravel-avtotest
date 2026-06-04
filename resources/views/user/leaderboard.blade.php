@extends('user.layouts.dashboard-layout')

@section('title', 'Reyting | Avtotest')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .lb { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* Period toggle */
    .period-pill {
        font-weight: 700;
        font-size: 13px;
        transition: all 0.2s ease;
        border-radius: 10px;
        padding: 8px 20px;
        color: #94a3b8;
    }
    .period-pill:hover { color: #1e293b; background: #f1f5f9; }
    .period-pill.active {
        background: #1e293b;
        color: #fff;
        box-shadow: 0 4px 12px rgba(30,41,59,0.2);
    }

    /* Podium kartochkalar */
    .podium-card {
        transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s ease;
        cursor: default;
    }
    .podium-card:hover { transform: translateY(-8px) !important; box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }

    /* 1-o'rin */
    .rank1-card {
        background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(15,23,42,0.25);
    }
    .rank2-card, .rank3-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    /* Avatar */
    .avatar-1 { box-shadow: 0 0 0 3px #f59e0b, 0 0 0 6px rgba(245,158,11,0.2); border-radius: 18px; }
    .avatar-2 { box-shadow: 0 0 0 3px #cbd5e1; border-radius: 14px; }
    .avatar-3 { box-shadow: 0 0 0 3px #fed7aa; border-radius: 12px; }

    /* Toj animatsiya */
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
    .crown { animation: float 2.5s ease-in-out infinite; display: inline-block; }

    /* XP gradient matn */
    .xp-gold {
        background: linear-gradient(135deg, #f59e0b, #f97316);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        font-weight: 800;
    }
    .xp-dark { color: #1e293b; font-weight: 800; }

    /* Ro'yxat qatorlari */
    .rank-row {
        transition: all 0.18s ease;
        border-left: 3px solid transparent;
        opacity: 0;
        transform: translateX(-8px);
    }
    .rank-row.visible {
        opacity: 1;
        transform: translateX(0);
    }
    .rank-row:hover {
        background: #f8fafc;
        border-left-color: #f59e0b;
    }
    .rank-row.is-me {
        background: linear-gradient(90deg, #fffbeb, #fff);
        border-left-color: #f59e0b;
    }

    /* Rank badge */
    .rank-badge {
        font-weight: 800;
        font-size: 13px;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Sticky panel */
    .sticky-me {
        background: #1e293b;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(15,23,42,0.3);
    }

    /* Kirish animatsiyasi */
    @keyframes slide-up { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .a1 { animation: slide-up 0.4s ease forwards; }
    .a2 { animation: slide-up 0.4s 0.08s ease forwards; opacity:0; }
    .a3 { animation: slide-up 0.4s 0.16s ease forwards; opacity:0; }
    .a4 { animation: slide-up 0.4s 0.24s ease forwards; opacity:0; }

    /* Pulse */
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(1.4)} }
    .pulse { animation: pulse 2s ease infinite; }

    /* Shimmer 1-o'rin XP */
    @keyframes shimmer { 0%{background-position:-200% center} 100%{background-position:200% center} }
    .shimmer {
        background: linear-gradient(90deg, #f59e0b, #fde68a, #f97316, #f59e0b);
        background-size: 200% auto;
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        animation: shimmer 2.5s linear infinite;
        font-weight: 800;
    }
</style>

<div class="lb max-w-2xl mx-auto pb-28">

    {{-- SARLAVHA --}}
    <div class="text-center mb-8 a1">
        <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-100 rounded-full px-4 py-1.5 mb-4">
            <span class="pulse inline-block w-2 h-2 rounded-full bg-amber-400"></span>
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Jonli reyting</span>
        </div>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Eng yaxshilar</h1>
        <p class="text-slate-400 text-sm font-medium">Bilim va matonat sinovida g'olib chiqing</p>
    </div>

    {{-- PERIOD TOGGLE --}}
    <div class="flex justify-center mb-10 a2">
        <div class="inline-flex bg-slate-100 p-1 rounded-xl gap-0.5">
            <a href="{{ route('leaderboard', ['period' => 'weekly']) }}"
               class="period-pill {{ $period === 'weekly' ? 'active' : '' }}">Haftalik</a>
            <a href="{{ route('leaderboard', ['period' => 'monthly']) }}"
               class="period-pill {{ $period === 'monthly' ? 'active' : '' }}">Oylik</a>
            <a href="{{ route('leaderboard', ['period' => 'all']) }}"
               class="period-pill {{ $period === 'all' ? 'active' : '' }}">Jami vaqt</a>
        </div>
    </div>

    {{-- TOP 3 PODIUM --}}
    <div class="grid grid-cols-3 gap-3 items-end mb-8 a3">

        {{-- 2-O'RIN --}}
        <div class="podium-card" style="transform: translateY(16px);">
            @if($top2)
            <div class="rank2-card p-5 text-center">
                <div class="w-14 h-14 mx-auto mb-3 avatar-2 overflow-hidden">
                    <img src="{{ $top2->avatar ? asset('storage/' . $top2->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($top2->name).'&background=e2e8f0&color=475569&bold=true&size=128' }}"
                         class="w-full h-full object-cover" style="border-radius:14px;">
                </div>
                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center font-extrabold text-xs mx-auto mb-2">2</div>
                <p class="font-bold text-slate-800 text-sm truncate mb-1">{{ $top2->name }}</p>
                <p class="xp-dark text-base">{{ $top2->period_xp }} <span class="text-xs text-slate-400 font-semibold">XP</span></p>
            </div>
            @else
            <div class="rank2-card p-5 text-center opacity-40">
                <div class="w-14 h-14 mx-auto mb-3 bg-slate-100 rounded-2xl"></div>
                <div class="w-7 h-7 rounded-lg bg-slate-100 mx-auto mb-2"></div>
                <div class="h-3 bg-slate-100 rounded mx-auto w-16"></div>
            </div>
            @endif
        </div>

        {{-- 1-O'RIN --}}
        <div class="podium-card" style="transform: translateY(0px); z-index:10;">
            @if($top1)
            <div class="rank1-card p-6 text-center relative" style="background: #92DCF0 !important;">
                <div class="crown text-2xl mb-2">👑</div>
                <div class="w-20 h-20 mx-auto mb-3 avatar-1 overflow-hidden">
                    <img src="{{ $top1->avatar ? asset('storage/' . $top1->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($top1->name).'&background=1e293b&color=f59e0b&bold=true&size=128' }}"
                         class="w-full h-full object-cover" style="border-radius:18px;">
                </div>
                <div class="w-8 h-8 rounded-xl mx-auto mb-3 flex items-center justify-center font-extrabold text-sm"
                     style="background: linear-gradient(135deg,#f59e0b,#f97316); color:#fff; box-shadow:0 4px 12px rgba(249,115,22,0.4);">1</div>
                <p class="font-extrabold text-slate-900 text-base truncate mb-1">{{ $top1->name }}</p>
                <p class="shimmer text-xl">{{ $top1->period_xp }} XP</p>
            </div>
            @else
            <div class="rank1-card p-6 text-center opacity-30">
                <div class="text-2xl mb-2">👑</div>
                <div class="w-20 h-20 mx-auto mb-3 bg-slate-700 rounded-2xl"></div>
                <div class="h-3 bg-slate-700 rounded mx-auto w-20 mb-2"></div>
                <div class="h-4 bg-slate-700 rounded mx-auto w-16"></div>
            </div>
            @endif
        </div>

        {{-- 3-O'RIN --}}
        <div class="podium-card" style="transform: translateY(24px);">
            @if($top3)
            <div class="rank3-card p-4 text-center">
                <div class="w-12 h-12 mx-auto mb-3 avatar-3 overflow-hidden">
                    <img src="{{ $top3->avatar ? asset('storage/' . $top3->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($top3->name).'&background=fff7ed&color=f97316&bold=true&size=128' }}"
                         class="w-full h-full object-cover" style="border-radius:12px;">
                </div>
                <div class="w-6 h-6 rounded-lg mx-auto mb-2 flex items-center justify-center font-extrabold text-xs"
                     style="background:#fff7ed; color:#f97316;">3</div>
                <p class="font-bold text-slate-800 text-sm truncate mb-1">{{ $top3->name }}</p>
                <p class="text-sm font-bold text-slate-600">{{ $top3->period_xp }} <span class="text-xs text-slate-400">XP</span></p>
            </div>
            @else
            <div class="rank3-card p-4 text-center opacity-40">
                <div class="w-12 h-12 mx-auto mb-3 bg-slate-100 rounded-xl"></div>
                <div class="w-6 h-6 rounded-lg bg-slate-100 mx-auto mb-2"></div>
                <div class="h-3 bg-slate-100 rounded mx-auto w-14"></div>
            </div>
            @endif
        </div>

    </div>

    {{-- QOLGAN ISHTIROKCHILAR --}}
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm a4">

        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-50">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Barcha ishtirokchilar</span>
            <span class="flex items-center gap-1.5 text-xs text-emerald-500 font-bold">
                <span class="pulse inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Jonli
            </span>
        </div>

        <ul id="rank-list" class="divide-y divide-slate-50">
            @forelse($otherUsers as $index => $user)
            <li class="rank-row flex items-center justify-between px-5 py-3.5 {{ $user->id === auth()->id() ? 'is-me' : '' }}"
                data-delay="{{ $index * 50 }}">

                <div class="flex items-center gap-3">
                    {{-- Rank badge --}}
                    <div class="rank-badge text-slate-400 bg-slate-50">{{ $index + 4 }}</div>

                    {{-- Avatar --}}
                    <div class="relative">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f1f5f9&color=64748b&bold=true&size=64' }}"
                             class="w-10 h-10 rounded-xl object-cover border border-slate-100">
                        @if($user->id === auth()->id())
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-amber-400 border-2 border-white flex items-center justify-center">
                            <i class="fas fa-star text-[6px] text-white"></i>
                        </div>
                        @endif
                    </div>

                    {{-- Ism --}}
                    <div>
                        <p class="font-semibold text-slate-800 text-sm leading-tight">{{ $user->name }}</p>
                        @if($user->id === auth()->id())
                        <span class="text-[9px] font-extrabold text-amber-500 uppercase tracking-widest">Siz</span>
                        @endif
                    </div>
                </div>

                {{-- XP --}}
                <div class="text-right">
                    <span class="font-extrabold text-slate-800 text-sm">{{ $user->period_xp }}</span>
                    <span class="text-xs text-slate-400 font-semibold ml-0.5">XP</span>
                </div>
            </li>
            @empty
            <li class="px-5 py-12 text-center">
                <i class="fas fa-users text-3xl text-slate-200 mb-3 block"></i>
                <p class="text-slate-400 text-sm font-medium">Hozircha boshqa ishtirokchilar yo'q</p>
            </li>
            @endforelse
        </ul>
    </div>

    {{-- STICKY JORIY USER --}}
    @if($currentUserRank)
    <div class="fixed bottom-5 left-1/2 -translate-x-1/2 w-full max-w-sm px-4 z-50">
        <div class="sticky-me px-5 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-extrabold text-base"
                     style="background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.2);">
                    {{ $currentUserRank }}
                </div>
                <div>
                    <p class="text-[9px] text-amber-400 font-extrabold uppercase tracking-widest mb-0.5">Sizning o'rningiz</p>
                    <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="shimmer text-lg">{{ $currentUserXp }}</p>
                <p class="text-slate-500 text-[9px] font-bold uppercase tracking-wider">XP</p>
            </div>
        </div>
    </div>
    @endif

</div>

<script>
    // Qatorlarni ketma-ket chiqarish
    document.querySelectorAll('.rank-row').forEach(row => {
        const delay = parseInt(row.dataset.delay) || 0;
        setTimeout(() => row.classList.add('visible'), 300 + delay);
    });
</script>

@endsection