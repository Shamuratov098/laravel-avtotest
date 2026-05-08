@extends('user.layouts.dashboard-layout')

@section('title', 'Reyting | Avtotest')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-12 animate-fade-in">

    <!-- Sarlavha va Vaqt filtri -->
    <div class="text-center space-y-6">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Reyting jadvallari</h1>
        
        <div class="inline-flex bg-white p-1 rounded-2xl border border-slate-100 shadow-sm">
            <a href="{{ route('leaderboard', ['period' => 'weekly']) }}" class="px-6 py-2.5 rounded-xl font-bold text-sm transition {{ $period === 'weekly' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Haftalik</a>
            <a href="{{ route('leaderboard', ['period' => 'monthly']) }}" class="px-6 py-2.5 rounded-xl font-bold text-sm transition {{ $period === 'monthly' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Oylik</a>
            <a href="{{ route('leaderboard', ['period' => 'all']) }}" class="px-6 py-2.5 rounded-xl font-bold text-sm transition {{ $period === 'all' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Jami vaqt</a>
        </div>
    </div>

    <!-- Top 3 O'rinlar (Faqat ma'lumot bo'lsagina chiqadi) -->
    <div class="grid grid-cols-3 gap-4 items-end mt-12 mb-8">
        
        <!-- 2-O'rin -->
        @if($top2)
        <div class="bg-white rounded-t-3xl border border-slate-100 shadow-sm p-4 text-center border-b-4 border-b-slate-300 relative pt-12 transform translate-y-4">
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 w-16 h-16 rounded-full border-4 border-white shadow-md bg-slate-100 overflow-hidden">
                <img src="{{ $top2->avatar ? asset('storage/' . $top2->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($top2->name).'&background=random' }}" class="w-full h-full object-cover">
            </div>
            <div class="w-8 h-8 mx-auto bg-slate-200 text-slate-600 rounded-full flex items-center justify-center font-black mb-2 mt-2">2</div>
            <h3 class="font-bold text-slate-800 truncate">{{ $top2->name }}</h3>
            <p class="text-blue-600 font-black">{{ $top2->period_xp }} XP</p>
        </div>
        @endif

        <!-- 1-O'rin -->
        @if($top1)
        <div class="bg-white rounded-t-3xl border border-slate-100 shadow-lg p-4 text-center border-b-4 border-b-amber-400 relative pt-16 z-10">
            <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full border-4 border-white shadow-lg bg-amber-100 overflow-hidden">
                <img src="{{ $top1->avatar ? asset('storage/' . $top1->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($top1->name).'&background=random' }}" class="w-full h-full object-cover">
            </div>
            <i class="fas fa-crown absolute -top-16 left-1/2 -translate-x-1/2 text-amber-400 text-3xl drop-shadow-md"></i>
            <div class="w-10 h-10 mx-auto bg-amber-400 text-white rounded-full flex items-center justify-center font-black text-lg mb-2 mt-2 shadow-inner">1</div>
            <h3 class="font-extrabold text-slate-900 truncate text-lg">{{ $top1->name }}</h3>
            <p class="text-amber-500 font-black text-xl">{{ $top1->period_xp }} XP</p>
        </div>
        @endif

        <!-- 3-O'rin -->
        @if($top3)
        <div class="bg-white rounded-t-3xl border border-slate-100 shadow-sm p-4 text-center border-b-4 border-b-orange-400 relative pt-10 transform translate-y-8">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full border-4 border-white shadow-md bg-orange-50 overflow-hidden">
                <img src="{{ $top3->avatar ? asset('storage/' . $top3->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($top3->name).'&background=random' }}" class="w-full h-full object-cover">
            </div>
            <div class="w-7 h-7 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-black mb-2 mt-2 text-sm">3</div>
            <h3 class="font-bold text-slate-800 truncate text-sm">{{ $top3->name }}</h3>
            <p class="text-blue-600 font-black">{{ $top3->period_xp }} XP</p>
        </div>
        @endif

    </div>

    <!-- Qolgan ishtirokchilar ro'yxati -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <ul class="divide-y divide-slate-50">
            @forelse($otherUsers as $index => $user)
            <li class="flex items-center justify-between p-4 md:p-5 hover:bg-slate-50 transition">
                <div class="flex items-center gap-4">
                    <span class="w-8 font-bold text-slate-400 text-right">{{ $index + 4 }}</span>
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="w-12 h-12 rounded-xl object-cover border border-slate-100">
                    <div>
                        <h4 class="font-bold text-slate-800">{{ $user->name }}</h4>
                        @if($user->id === auth()->id())
                            <span class="text-[10px] uppercase font-bold tracking-wider bg-blue-100 text-blue-600 px-2 py-0.5 rounded-md">Bu siz</span>
                        @endif
                    </div>
                </div>
                <div class="font-black text-slate-600">
                    {{ $user->period_xp }} <span class="text-xs text-slate-400 font-bold">XP</span>
                </div>
            </li>
            @empty
            <li class="p-8 text-center text-slate-500 font-medium">Hozircha ishtirokchilar yo'q.</li>
            @endforelse
        </ul>
    </div>

    <!-- Joriy foydalanuvchining shaxsiy ko'rsatkichi (Ekranning pastida doim ko'rinib turadi) -->
    @if($currentUserRank)
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-2xl px-4 z-50">
        <div class="bg-slate-800 rounded-2xl p-4 flex items-center justify-between shadow-2xl shadow-slate-900/20 border border-slate-700">
            <div class="flex items-center gap-4 text-white">
                <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center font-black text-xl border border-slate-600">
                    {{ $currentUserRank }}
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Sizning o'rningiz</p>
                    <p class="font-bold truncate max-w-[150px] md:max-w-none">{{ auth()->user()->name }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-blue-400 font-black text-xl">{{ $currentUserXp }} <span class="text-sm">XP</span></p>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection