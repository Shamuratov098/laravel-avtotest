@extends('user.layouts.dashboard-layout')

@section('title', 'Avtotest - Asosiy sahifa')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 animate-fade-in pb-12">

    <!-- 1. Sarlavha qismi -->
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Xush kelibsiz, {{ auth()->user()->name }}!</h1>
        <p class="text-slate-500 mt-2 font-medium">Hurmatli o'quvchi, sizga haydovchilik guvohnomasini olishingizga ko'mak berayotganimizdan mamnunmiz!</p>
    </div>

    <!-- ========================================== -->
    <!-- 4. TEZKOR HAVOLALAR (Sizning kodingiz) -->
    <!-- ========================================== -->
    <div>
        <h2 class="text-lg font-bold text-slate-800 mb-4 tracking-tight">Tezkor amallar</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            
            <!-- Imtihon topshirish -->
            <a href="{{ route('tests.index') }}" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition group">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-play text-lg"></i>
                </div>
                <span class="font-bold text-slate-700 group-hover:text-blue-600 transition">Imtihon topshirish</span>
            </a>

            <!-- Savollar to'plami -->
            <a href="#" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-purple-200 transition group">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-book-open text-lg"></i>
                </div>
                <span class="font-bold text-slate-700 group-hover:text-purple-600 transition">Savollar to'plami</span>
            </a>

            <!-- Reyting -->
            <a href="{{ route('leaderboard') }}" class="flex items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-cyan-200 transition group">
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-ranking-star text-lg"></i>
                </div>
                <span class="font-bold text-slate-700 group-hover:text-cyan-600 transition">Reyting</span>
            </a>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- AMALIY IMTIHON ANIMATSIYASI (YANGI) -->
    <!-- ========================================== -->
    <div class="mb-8">
        <div class="relative w-full h-48 bg-gradient-to-b from-sky-300 to-sky-100 rounded-2xl overflow-hidden shadow-sm border border-sky-200 select-none group">
            
            <!-- Matn qismi -->
            <div class="absolute top-4 left-6 z-10">
                <h2 class="text-2xl font-black text-slate-800 tracking-wider uppercase drop-shadow-md">Avto Test</h2>
            </div>

            <!-- Quyosh (Dekoratsiya) -->
            <div class="absolute top-6 right-12 w-10 h-10 bg-yellow-300 rounded-full shadow-[0_0_30px_rgba(253,224,71,1)]"></div>

            <!-- Yo'l -->
            <div class="absolute bottom-0 w-full h-20 bg-slate-700 border-t-8 border-emerald-500 shadow-inner">
                <!-- Yo'l chiziqlari -->
                <div class="absolute top-1/2 left-0 w-full h-1 border-t-[4px] border-dashed border-white opacity-60 transform -translate-y-1/2"></div>
            </div>

            <!-- Svetafor -->
            <div class="absolute bottom-16 right-1/4 w-7 h-16 bg-slate-800 rounded-lg flex flex-col items-center justify-evenly z-20 shadow-xl border-2 border-slate-900">
                <div id="light-red" class="w-4 h-4 rounded-full bg-red-500 opacity-20 transition-all duration-300"></div>
                <div id="light-yellow" class="w-4 h-4 rounded-full bg-yellow-400 opacity-20 transition-all duration-300"></div>
                <div id="light-green" class="w-4 h-4 rounded-full bg-green-500 opacity-100 shadow-[0_0_10px_#22c55e] transition-all duration-300"></div>
                <!-- Svetafor ustuni -->
                <div class="absolute w-1.5 h-16 bg-slate-500 bottom-[-64px] z-[-1] border-x border-slate-600"></div> 
            </div>

            <!-- Harakatlanuvchi Moshina -->
            <div id="animated-car" class="absolute bottom-[22px] left-[-100px] z-30 transition-transform duration-75" style="transform: translateX(-100px);">
                <!-- Avtotest rangidagi moshina -->
                <i class="fas fa-car-side text-[55px] text-blue-600 drop-shadow-[2px_4px_4px_rgba(0,0,0,0.4)]"></i>
            </div>
            
        </div>
    </div>

    <!-- ANIMATSIYA LOGIKASI (JS) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const car = document.getElementById('animated-car');
            const redL = document.getElementById('light-red');
            const yellowL = document.getElementById('light-yellow');
            const greenL = document.getElementById('light-green');

            let carX = -100; // Moshina boshlanish nuqtasi
            let isGreen = true;
            let speed = 2.5; // Yurish tezligi
            let container = car.parentElement;

            // Svetafor ranglarini o'zgartirish logikasi
            function changeTrafficLight() {
                if (isGreen) {
                    // Yashildan -> Sariqqa -> Qizilga
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
                    }, 1500); // 1.5 sekund sariq yonadi
                } else {
                    // Qizildan -> Yashilga
                    redL.classList.replace('opacity-100', 'opacity-20');
                    redL.style.boxShadow = 'none';
                    greenL.classList.replace('opacity-20', 'opacity-100');
                    greenL.style.boxShadow = '0 0 15px #22c55e';
                    isGreen = true;
                }
            }

            // Svetafor har 5 sekundda o'zgaradi
            setInterval(changeTrafficLight, 5000); 

            // Moshina harakati logikasi
            function driveCar() {
                let containerWidth = container.offsetWidth;
                // Svetafor turgan joyni aniqlash (taxminan ekranning o'ng tomonida 1/4 qismida)
                let stopLine = containerWidth - (containerWidth / 4) - 80;

                // Tormoz bosish (Agar qizil bo'lsa va moshina svetaforga yaqinlashsa)
                if (!isGreen && carX >= stopLine - 10 && carX <= stopLine + 10) {
                    // To'xtab turadi
                } else {
                    carX += speed; // Harakatlanadi
                }

                // Ekrandan chiqib ketsa, yana boshidan keladi
                if (carX > containerWidth + 100) {
                    carX = -100;
                }

                car.style.transform = `translateX(${carX}px)`;
                requestAnimationFrame(driveCar); // Silliq animatsiya uchun
            }

            // Animatsiyani ishga tushirish
            requestAnimationFrame(driveCar);
        });
    </script>

    <!-- ========================================== -->
    <!-- 2. UMUMIY KO'RSATKICHLAR (Sizning kodingiz) -->
    <!-- ========================================== -->
    <div>
        <h2 class="text-lg font-bold text-slate-800 mb-4 tracking-tight">Umumiy ko'rsatkichlar</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Jami XP Kartochkasi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Jami to'plangan XP</p>
                    <p class="text-3xl font-black text-slate-800">{{ number_format($stats['xp'] ?? 0) }}</p>
                </div>
            </div>

            <!-- O'zlashtirish Foizi Kartochkasi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">O'zlashtirish foizi</p>
                    <p class="text-3xl font-black text-slate-800">{{ $stats['percentage'] ?? 0 }}%</p>
                </div>
            </div>

            <!-- Tugatilgan Testlar Kartochkasi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tugatilgan testlar</p>
                    <p class="text-3xl font-black text-slate-800">{{ number_format($stats['total_tests'] ?? 0) }} ta</p>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- 3. IMTIHON NATIJALARI (Yangi qo'shilgan) -->
    <!-- ========================================== -->
    <div>
        <h2 class="text-lg font-bold text-slate-800 mb-4 tracking-tight">Imtihon statistikasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Haqiqiy imtihon -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Haqiqiy imtihon</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['totalExams'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>

            <!-- O'tganlar -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Muvaffaqiyatli</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['passedExams'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>

            <!-- Yiqilganlar -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow hover:border-red-100">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-circle-xmark"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Yiqilganlar</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['failedExams'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>

            <!-- Oddiy testlar -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-violet-100 text-violet-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Oddiy mashqlar</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['totalPractices'] ?? 0 }} <span class="text-sm font-medium text-slate-400">marta</span></h3>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection