@extends('layouts.dashboard-layout')

@section('title', 'Avtotest - Global Reyting')

@section('content')
<div class="max-w-4xl mx-auto py-8 animate-fade-in pb-24">

    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Global reyting</h1>
        <p class="text-slate-500 mt-2 font-medium">Boshqa o'quvchilar bilan bellashing, XP (Tajriba ballari) to'plang va har bir darajada yanada kuchliroq bo'lib boring.</p>
    </div>

    <div class="flex justify-center mb-12">
        <div class="bg-white p-1 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-1">
            <a href="{{ route('leaderboard', ['period' => 'weekly']) }}" 
               class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $period === 'weekly' ? 'bg-blue-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                Haftalik
            </a>
            <a href="{{ route('leaderboard', ['period' => 'monthly']) }}" 
               class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $period === 'monthly' ? 'bg-blue-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                Oylik
            </a>
            <a href="{{ route('leaderboard', ['period' => 'all']) }}" 
               class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $period === 'all' ? 'bg-blue-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                Barcha vaqtlar
            </a>
        </div>
    </div>

    @if($top1)
        <div class="flex items-end justify-center gap-2 md:gap-6 mb-16 h-64">
            
            @if($top2)
            <div class="flex flex-col items-center w-28 md:w-36 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="relative mb-3">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-slate-700 text-white text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full z-10 shadow-md">Kumush</span>
                    <img src="{{ $top2->avatar ? asset('storage/'.$top2->avatar) : 'https://ui-avatars.com/api/?name='.$top2->name.'&background=e2e8f0&color=475569' }}" class="w-16 h-16 rounded-full border-4 border-slate-200 object-cover shadow-lg relative z-0">
                </div>
                <p class="text-sm font-bold text-slate-700 truncate w-full text-center">{{ $top2->name }}</p>
                <p class="text-blue-500 font-black text-sm mb-3">{{ number_format($top2->period_xp) }} XP</p>
                <div class="w-full bg-slate-100/80 rounded-t-2xl h-24 flex items-center justify-center border-t border-x border-slate-200 shadow-inner">
                    <span class="text-4xl font-black text-slate-300">2</span>
                </div>
            </div>
            @endif

            <div class="flex flex-col items-center w-32 md:w-44 z-10 animate-slide-up">
                <div class="relative mb-3">
                    <i class="fas fa-crown absolute -top-8 left-1/2 -translate-x-1/2 text-amber-400 text-4xl filter drop-shadow-md z-20"></i>
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-0.5 rounded-full z-10 shadow-md border-2 border-white">Master</span>
                    <img src="{{ $top1->avatar ? asset('storage/'.$top1->avatar) : 'https://ui-avatars.com/api/?name='.$top1->name.'&background=fbbf24&color=fff' }}" class="w-20 h-20 rounded-full border-4 border-amber-400 object-cover shadow-xl relative z-0 ring-4 ring-amber-50">
                </div>
                <p class="text-base font-black text-slate-800 truncate w-full text-center">{{ $top1->name }}</p>
                <p class="text-amber-500 font-black text-base mb-3">{{ number_format($top1->period_xp) }} XP</p>
                <div class="w-full bg-blue-50/80 rounded-t-2xl h-36 flex items-start justify-center pt-6 border-t border-x border-blue-100 shadow-inner">
                    <span class="text-6xl font-black text-blue-200">1</span>
                </div>
            </div>

            @if($top3)
            <div class="flex flex-col items-center w-28 md:w-36 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="relative mb-3">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-orange-600 text-white text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full z-10 shadow-md">Bronza</span>
                    <img src="{{ $top3->avatar ? asset('storage/'.$top3->avatar) : 'https://ui-avatars.com/api/?name='.$top3->name.'&background=ffedd5&color=ea580c' }}" class="w-16 h-16 rounded-full border-4 border-orange-200 object-cover shadow-lg relative z-0">
                </div>
                <p class="text-sm font-bold text-slate-700 truncate w-full text-center">{{ $top3->name }}</p>
                <p class="text-blue-500 font-black text-sm mb-3">{{ number_format($top3->period_xp) }} XP</p>
                <div class="w-full bg-slate-50/80 rounded-t-2xl h-20 flex items-center justify-center border-t border-x border-slate-100 shadow-inner">
                    <span class="text-4xl font-black text-slate-200">3</span>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">O'rin</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">O'quvchi</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Jami XP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($otherUsers as $index => $user)
                        <tr class="hover:bg-slate-50 transition group {{ auth()->id() == $user->id ? 'bg-blue-50/50' : '' }}">
                            <td class="px-6 py-4">
                                <span class="text-sm font-black text-slate-400 group-hover:text-slate-600 transition">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=f1f5f9&color=64748b' }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">{{ $user->name }} {{ auth()->id() == $user->id ? '(Siz)' : '' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-xl">{{ number_format($user->period_xp) }} XP</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center bg-white p-12 rounded-[32px] border border-slate-100 shadow-sm">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fas fa-ghost"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Hozircha natijalar yo'q</h3>
            <p class="text-sm text-slate-400 mt-1">Bu vaqt oralig'ida hali hech kim test ishlamadi.</p>
        </div>
    @endif
</div>

<div class="fixed bottom-0 left-0 md:left-[280px] right-0 bg-blue-500 text-white py-4 px-6 md:px-12 shadow-[0_-10px_30px_rgba(59,130,246,0.3)] z-50 flex items-center justify-between">
    <div class="flex items-center gap-6">
        <div class="text-center border-r border-blue-400 pr-6">
            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200 mb-1">Sizning o'rningiz</p>
            <p class="text-2xl font-black leading-none">
                {{ $currentUserRank ? '#'.$currentUserRank : '-' }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name.'&background=fff&color=3b82f6' }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
            <div>
                <p class="text-sm font-bold">{{ auth()->user()->name }} (Siz)</p>
                <p class="text-xs text-blue-100 font-medium">Bilim oshishi bilan reytingingiz yangilanadi.</p>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="text-right hidden md:block">
            <p class="text-xl font-black">{{ number_format($currentUserXp) }} XP</p>
        </div>
        <a href="{{ route('tests.index') }}" class="bg-white text-blue-600 px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-blue-50 transition">
            XP oshirish
        </a>
    </div>
</div>

<style>
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up {
        animation: slide-up 0.5s ease-out forwards;
        opacity: 0;
    }
</style>
@endsection