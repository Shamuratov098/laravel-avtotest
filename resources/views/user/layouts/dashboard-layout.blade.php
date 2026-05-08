<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Har bir sahifa o'z sarlavhasini yuboradi, kelmasa 'Avtotest' chiqadi -->
    <title>@yield('title', 'Avtotest')</title>
    
    <!-- Tailwind va FontAwesome (Sizda lokal bo'lsa lokalini ulang) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Oddiy animatsiya -->
    <style>
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex h-screen overflow-hidden">

    <!-- ========================================== -->
    <!-- CHAPT DAGI YON MENYU (SIDEBAR)             -->
    <!-- ========================================== -->
    <aside class="w-72 bg-white border-r border-slate-100 flex-col hidden md:flex z-20 shadow-sm">
        
        <!-- Logotip qismi -->
        <div class="h-20 flex items-center px-8 border-b border-slate-50">
            <div class="flex items-center gap-3 text-blue-600">
                <i class="fas fa-steering-wheel text-3xl"></i>
                <span class="text-2xl font-black tracking-tight">Avto<span class="text-slate-800">Test</span></span>
            </div>
        </div>

        <!-- Menyular ro'yxati -->
        <!-- request()->routeIs('...') orqali qaysi sahifada ekanligimizni aniqlaymiz va ko'k rangga kiritamiz -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
            
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                <i class="fas fa-home w-5 text-center text-lg"></i> Asosiy sahifa
            </a>

            <!-- tests.* degani 'tests.' bilan boshlanadigan hamma sahifada (kategoriya, random, natija) aktiv bo'ladi -->
            <a href="{{ route('tests.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold transition {{ request()->routeIs('tests.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                <i class="fas fa-file-signature w-5 text-center text-lg"></i> Imtihon topshirish
            </a>

            <a href="{{ route('leaderboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold transition {{ request()->routeIs('leaderboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                <i class="fas fa-trophy w-5 text-center text-lg"></i> Reyting
            </a>

        </nav>

        <!-- Pastki menyu (Profil) -->
        <div class="p-4 border-t border-slate-50">
            <a href="{{ route('profile') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold transition {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                <i class="fas fa-user-gear w-5 text-center text-lg"></i> Sozlamalar
            </a>
        </div>
    </aside>

    <!-- ========================================== -->
    <!-- O'NG TOMON (Asosiy kontent qismi)          -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- YUQORI PANEL (HEADER) -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0">
            
            <!-- Mobil menyu tugmasi (Hozircha faqat ko'rinish) -->
            <button class="md:hidden text-slate-500 hover:text-blue-600 text-2xl">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Bo'sh joy (Mobil menyu bo'lmasa o'ngga surish uchun) -->
            <div class="hidden md:block"></div>

            <!-- Foydalanuvchi qismi va Chiqish -->
            <div class="flex items-center gap-6">
                
                <!-- Foydalanuvchi ma'lumoti -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-xs font-bold text-blue-500">O'quvchi</p>
                    </div>
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" class="w-11 h-11 rounded-xl object-cover border-2 border-slate-100">
                </div>

                <!-- Ajratuvchi chiziq -->
                <div class="w-px h-8 bg-slate-200"></div>

                <!-- Tizimdan chiqish (Xavfsizlik uchun faqat POST so'rov orqali ishlashi kerak) -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors cursor-pointer group" title="Tizimdan chiqish">
                        <i class="fas fa-sign-out-alt group-hover:-translate-x-1 transition-transform"></i>
                    </button>
                </form>

            </div>
        </header>

        <!-- ASOSIY KONTENT (Boshqa sahifalar shu yerga tushadi) -->
        <main class="flex-1 overflow-y-auto bg-slate-50 p-6 lg:p-10 relative">
            @yield('content')
        </main>

    </div>

</body>
</html>