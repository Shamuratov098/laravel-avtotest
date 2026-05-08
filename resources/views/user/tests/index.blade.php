@extends('user.layouts.dashboard-layout')

@section('title', 'Test turini tanlash | Avtotest')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in pb-12">

    <!-- Sarlavha -->
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Imtihonga tayyormisiz?</h1>
        <p class="text-slate-500 font-medium">O'zingizga qulay bo'lgan test turini tanlang va bilimingizni sinab ko'ring.</p>
    </div>

    <!-- 1-Bo'lim: Aralash (Imtihon rejimi) -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border-2 border-blue-100 shadow-md relative overflow-hidden group hover:border-blue-500 transition-colors">
        <!-- Orqa fondagi katta ikonka (Dekoratsiya) -->
        <i class="fas fa-random absolute -right-4 -bottom-4 text-[120px] text-blue-50 opacity-50 group-hover:scale-110 transition-transform"></i>
        
        <div class="relative z-10">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-4">
                <i class="fas fa-bolt"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Haqiqiy imtihon rejimi (Aralash)</h2>
            <p class="text-slate-600 mb-6 max-w-lg">Barcha mavzulardan aralashtirib beriladi. Xuddi davlat imtihonidagidek tayyorgarlik ko'ring.</p>
            
            <div class="flex items-center gap-6 mb-6">
                <div class="flex items-center gap-2 text-slate-500 font-medium">
                    <i class="fas fa-list-ol"></i> 20 ta savol
                </div>
                <div class="flex items-center gap-2 text-slate-500 font-medium">
                    <i class="fas fa-clock"></i> 30 daqiqa
                </div>
            </div>

            <!-- Backendga yo'naltirish (Aralash testni boshlash URL i) -->
            <a href="{{ route('tests.random') }}" class="inline-flex bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md items-center gap-2">
                Boshlash <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- 2-Bo'lim: Kategoriyalar -->
    <div class="pt-4">
        <h2 class="text-xl font-bold text-slate-800 mb-6 px-2 flex items-center gap-2">
            <i class="fas fa-layer-group text-slate-400"></i> Mavzular bo'yicha tayyorgarlik
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Kategoriyalarni aylanib chiqish (Backenddan $categories keladi) -->
            @forelse($categories as $category)
                <a href="{{ route('tests.category', $category->id) }}" class="flex items-center justify-between bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-purple-200 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 group-hover:text-purple-600 transition">{{ $category->name }}</h3>
                            <p class="text-xs text-slate-400 font-bold mt-1">10 ta savol • 15 daqiqa</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-purple-500 transition"></i>
                </a>
            @empty
                <div class="col-span-2 text-center p-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-500 font-medium">Hozircha mavzular qo'shilmagan.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection