@extends('user.layouts.dashboard-layout')

@section('title', 'Avtotest - Asosiy sahifa')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 animate-fade-in pb-12">

    <!-- 1. Sarlavha -->
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Xush kelibsiz, {{ auth()->user()->name }}!</h1>
        <p class="text-slate-500 mt-2 font-medium">Hurmatli o'quvchi, sizga haydovchilik guvohnomasini olishingizda ko'mak berayotganimizdan mamnunmiz!</p>
    </div>

    <!-- 2. ANIMATSIYA -->
    <div class="mb-2">
        <div class="relative w-full h-48 bg-gradient-to-b from-sky-300 to-sky-100 rounded-2xl overflow-hidden shadow-sm border border-sky-200 select-none">
            <div class="absolute top-4 left-6 z-10">
                <h2 class="text-2xl font-black text-slate-800 tracking-wider uppercase drop-shadow-md">Avto Test</h2>
            </div>
            <div class="absolute top-6 right-12 w-10 h-10 bg-yellow-300 rounded-full shadow-[0_0_30px_rgba(253,224,71,1)]"></div>
            <div class="absolute bottom-0 w-full h-20 bg-slate-700 border-t-8 border-emerald-500 shadow-inner">
                <div class="absolute top-1/2 left-0 w-full h-1 border-t-[4px] border-dashed border-white opacity-60 transform -translate-y-1/2"></div>
            </div>
            <div class="absolute bottom-16 right-1/4 w-7 h-16 bg-slate-800 rounded-lg flex flex-col items-center justify-evenly z-20 shadow-xl border-2 border-slate-900">
                <div id="light-red" class="w-4 h-4 rounded-full bg-red-500 opacity-20 transition-all duration-300"></div>
                <div id="light-yellow" class="w-4 h-4 rounded-full bg-yellow-400 opacity-20 transition-all duration-300"></div>
                <div id="light-green" class="w-4 h-4 rounded-full bg-green-500 opacity-100 shadow-[0_0_10px_#22c55e] transition-all duration-300"></div>
                <div class="absolute w-1.5 h-16 bg-slate-500 bottom-[-64px] z-[-1] border-x border-slate-600"></div>
            </div>
            <div id="animated-car" class="absolute bottom-[22px] left-[-100px] z-30 transition-transform duration-75" style="transform: translateX(-100px);">
                <i class="fas fa-car-side text-[55px] text-blue-600 drop-shadow-[2px_4px_4px_rgba(0,0,0,0.4)]"></i>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4">
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jami XP</p>
                <p class="text-2xl font-black text-amber-500">{{ number_format($stats['xp'] ?? 0) }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">O'zlashtirish</p>
                <p class="text-2xl font-black text-blue-500">{{ $stats['percentage'] ?? 0 }}%</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tugatilgan</p>
                <p class="text-2xl font-black text-emerald-500">{{ number_format($stats['total_tests'] ?? 0) }} ta</p>
            </div>
        </div>
    </div>

    <!-- ANIMATSIYA JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const car = document.getElementById('animated-car');
            const redL = document.getElementById('light-red');
            const yellowL = document.getElementById('light-yellow');
            const greenL = document.getElementById('light-green');
            let carX = -100, isGreen = true, speed = 2.5;
            let container = car.parentElement;

            function changeTrafficLight() {
                if (isGreen) {
                    greenL.classList.replace('opacity-100', 'opacity-20');
                    greenL.style.boxShadow = 'none';
                    yellowL.classList.replace('opacity-20', 'opacity-100');
                    yellowL.style.boxShadow = '0 0 10px #facc15';
                    setTimeout(() => {
                        yellowL.classList.replace('opacity-100', 'opacity-20');
                        yellowL.style.boxShadow = 'none';
                        redL.classList.replace('opacity-20', 'opacity-100');
                        redL.style.boxShadow = '0 0 15px #ef4444';
                        isGreen = false;
                    }, 1500);
                } else {
                    redL.classList.replace('opacity-100', 'opacity-20');
                    redL.style.boxShadow = 'none';
                    greenL.classList.replace('opacity-20', 'opacity-100');
                    greenL.style.boxShadow = '0 0 15px #22c55e';
                    isGreen = true;
                }
            }
            setInterval(changeTrafficLight, 5000);

            function driveCar() {
                let containerWidth = container.offsetWidth;
                let stopLine = containerWidth - (containerWidth / 4) - 80;
                if (!isGreen && carX >= stopLine - 10 && carX <= stopLine + 10) {
                } else { carX += speed; }
                if (carX > containerWidth + 100) carX = -100;
                car.style.transform = `translateX(${carX}px)`;
                requestAnimationFrame(driveCar);
            }
            requestAnimationFrame(driveCar);
        });
    </script>

    <!-- 3. IMTIHON STATISTIKASI -->
    <div>
        <h2 class="text-lg font-bold text-slate-800 mb-4 tracking-tight">Imtihon statistikasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl"><i class="fas fa-file-signature"></i></div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Haqiqiy imtihon</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['totalExams'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl"><i class="fas fa-award"></i></div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Muvaffaqiyatli</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['passedExams'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow hover:border-red-100">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl"><i class="fas fa-circle-xmark"></i></div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Yiqilganlar</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['failedExams'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-violet-100 text-violet-600 rounded-xl flex items-center justify-center text-xl"><i class="fas fa-layer-group"></i></div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Oddiy mashqlar</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['totalPractices'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. OXIRGI URINISHLAR -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight">Oxirgi urinishlar</h2>
            {{-- Jami natija soni --}}
            <span class="text-xs text-slate-400 font-medium">
                Jami: {{ $stats['recentSessions']->total() }} ta
            </span>
        </div>

        {{-- =============================================
             FILTER PANELI
             URL parametrlari: ?type=...&status=...&sort=...
             withQueryString() tufayli paginatsiyada ham saqlanadi
             ============================================= --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-3 items-end">

                {{-- TUR filtri --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tur</label>
                    <select name="type" onchange="this.form.submit()"
                        class="text-sm font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-violet-300 cursor-pointer">
                        <option value="all"      {{ ($filters['type'] ?? 'all') === 'all'      ? 'selected' : '' }}>Hammasi</option>
                        <option value="random"   {{ ($filters['type'] ?? 'all') === 'random'   ? 'selected' : '' }}>Imtihon</option>
                        <option value="category" {{ ($filters['type'] ?? 'all') === 'category' ? 'selected' : '' }}>Mashq</option>
                    </select>
                </div>

                {{-- HOLAT filtri --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Holat</label>
                    <select name="status" onchange="this.form.submit()"
                        class="text-sm font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-violet-300 cursor-pointer">
                        <option value="all"      {{ ($filters['status'] ?? 'all') === 'all'      ? 'selected' : '' }}>Hammasi</option>
                        <option value="passed"   {{ ($filters['status'] ?? 'all') === 'passed'   ? 'selected' : '' }}>O'tdi</option>
                        <option value="failed"   {{ ($filters['status'] ?? 'all') === 'failed'   ? 'selected' : '' }}>Yiqildi</option>
                        <option value="practice" {{ ($filters['status'] ?? 'all') === 'practice' ? 'selected' : '' }}>Mashq</option>
                    </select>
                </div>

                {{-- SARALASH --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Saralash</label>
                    <select name="sort" onchange="this.form.submit()"
                        class="text-sm font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-violet-300 cursor-pointer">
                        <option value="newest" {{ ($filters['sort'] ?? 'newest') === 'newest' ? 'selected' : '' }}>Eng yangi</option>
                        <option value="oldest" {{ ($filters['sort'] ?? 'newest') === 'oldest' ? 'selected' : '' }}>Eng eski</option>
                    </select>
                </div>

                {{-- TOZALASH tugmasi — faqat filter qo'llanilgan bo'lsa ko'rinadi --}}
                @if(($filters['type'] ?? 'all') !== 'all' || ($filters['status'] ?? 'all') !== 'all' || ($filters['sort'] ?? 'newest') !== 'newest')
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-transparent uppercase tracking-widest">.</label>
                    <a href="{{ route('dashboard') }}"
                        class="text-sm font-bold text-slate-400 hover:text-red-500 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 transition flex items-center gap-1.5">
                        <i class="fas fa-xmark text-xs"></i> Tozalash
                    </a>
                </div>
                @endif

            </form>
        </div>

        {{-- JADVAL --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            @if($stats['recentSessions']->count() > 0)
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tur</th>
                        <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Natija</th>
                        <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Holat</th>
                        <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Sana</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($stats['recentSessions'] as $session)
                    @php
                        $isRandom   = $session->type->value === 'random';
                        $isPassed   = $isRandom && $session->total_questions == 20 && $session->correct_count >= 18;
                        $isFailed   = $isRandom && !$isPassed;
                        $percentage = $session->total_questions > 0
                            ? round(($session->correct_count / $session->total_questions) * 100)
                            : 0;
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            @if($isRandom)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                                    <i class="fas fa-shuffle text-[10px]"></i> Imtihon
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-violet-50 text-violet-600">
                                    <i class="fas fa-layer-group text-[10px]"></i> Mashq
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-800">{{ $session->correct_count }}/{{ $session->total_questions }}</span>
                            <span class="ml-2 text-xs text-slate-400 font-medium">{{ $percentage }}%</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($isRandom && $isPassed)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                    <i class="fas fa-check text-[10px]"></i> O'tdi
                                </span>
                            @elseif($isRandom && $isFailed)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-500">
                                    <i class="fas fa-xmark text-[10px]"></i> Yiqildi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                                    <i class="fas fa-pen text-[10px]"></i> Mashq
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 font-medium">
                            {{ $session->completed_at ? $session->completed_at->format('d.m.Y H:i') : $session->updated_at->format('d.m.Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginatsiya --}}
            @if($stats['recentSessions']->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $stats['recentSessions']->links('pagination::tailwind') }}
            </div>
            @endif

            @else
            <div class="text-center py-16 text-slate-400">
                <i class="fas fa-inbox text-4xl mb-3 block opacity-30"></i>
                <p class="font-medium">Hech qanday natija topilmadi</p>
                @if(($filters['type'] ?? 'all') !== 'all' || ($filters['status'] ?? 'all') !== 'all')
                    <a href="{{ route('dashboard') }}" class="mt-3 inline-block text-sm text-violet-500 font-bold hover:underline">
                        Filtrlarni tozalash
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>

</div>
@endsection