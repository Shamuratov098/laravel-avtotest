@extends('layouts.dashboard-layout')

@section('title', 'Avtotest - Asosiy sahifa')

@section('content')
<div class="max-w-5xl space-y-8 animate-fade-in">
    
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Xush kelibsiz, {{ auth()->user()->name }}!</h1>
        <p class="text-slate-500 mt-2 font-medium">Hurmatli o'quvchi, sizga haydovchilik guvohnomasini olishingizga ko'mak berayotganimizdan mamnunmiz!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <a href="{{ route('tests.index') }}" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-play text-sm"></i>
            </div>
            <span class="font-bold text-slate-700">Imtihon topshirish</span>
        </a>

        <a href="{{ route('tests.index') }}" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-layer-group text-sm"></i>
            </div>
            <span class="font-bold text-slate-700">Savollar to'plami</span>
        </a>

        <a href="{{ route('leaderboard') }}" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group">
            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-chart-simple text-sm"></i>
            </div>
            <span class="font-bold text-slate-700">Reyting</span>
        </a>

        <a href="{{ route('profile') }}" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-user text-sm"></i>
            </div>
            <span class="font-bold text-slate-700">Profil</span>
        </a>

    </div>

    <div class="bg-blue-600 rounded-[32px] p-8 md:p-12 text-white shadow-xl shadow-blue-200 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        
        <div class="relative z-10 max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-4">Bilimingizni sinab ko'rishga tayyormisiz?</h2>
            <p class="text-blue-100 mb-8 leading-relaxed font-medium">Rasmiy vaqt cheklovlari asosida to'liq sinov imtihonini yeching. Bu sizni haqiqiy imtihonga puxta tayyorlaydi.</p>
            <a href="{{ route('tests.index') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-sm">
                <i class="fas fa-play text-sm"></i> Imtihonni boshlash
            </a>
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-extrabold text-slate-800">Sizning yutuqlaringiz</h3>
            <span class="text-sm font-medium text-slate-400">Tajriba, ketma-ketlik va yutuqlar — barchasi bir joyda.</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-6">
                <div class="w-20 h-24 bg-blue-600 rounded-2xl flex flex-col items-center justify-center text-white shadow-lg shadow-blue-200 shrink-0">
                    <span class="text-3xl font-black">1</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest opacity-80 mt-1">Daraja</span>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">Jami tajriba</p>
                    <h4 class="text-2xl font-black text-slate-800 mb-4">0 <span class="text-sm text-slate-400 font-bold">XP</span></h4>
                    
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-400 mb-2">
                            <span>Keyingi darajagacha 100 XP qoldi</span>
                            <span>0%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-600 h-full rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-orange-100 shadow-sm flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -z-0"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-6">
                    <div>
                        <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">Kunlik faollik</p>
                        <h4 class="text-4xl font-black text-slate-800">0 <span class="text-base text-slate-400 font-bold">kun</span></h4>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
                
                <div class="relative z-10 flex justify-between text-sm font-bold text-slate-400 pt-4 border-t border-slate-50">
                    <span>Rekord: 0</span>
                    <span>So'nggi mashg'ulot: Yo'q</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection