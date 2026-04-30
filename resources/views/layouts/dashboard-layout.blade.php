<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Avtotest - Boshqaruv paneli')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#f8f9fa] h-screen flex overflow-hidden text-slate-800 relative">

    <div id="mobile-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 z-40 hidden md:hidden backdrop-blur-sm transition-opacity opacity-0"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-[280px] bg-white border-r border-slate-100 flex flex-col justify-between shadow-2xl md:shadow-[4px_0_24px_rgba(0,0,0,0.02)] transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out">
        
        <div>
            <div class="p-6 md:p-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <i class="fas fa-car text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-800 tracking-tight leading-none">Avtotest</h1>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Boshqaruv paneli</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="px-4 space-y-1 mt-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-semibold text-sm {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    <i class="fas fa-border-all w-5 text-center text-lg {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i> Asosiy sahifa
                </a>
                <a href="{{ route('tests.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-semibold text-sm {{ request()->routeIs('tests.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    <i class="fas fa-play w-5 text-center text-lg {{ request()->routeIs('tests.*') ? 'text-blue-600' : 'text-slate-400' }}"></i> Imtihon topshirish
                </a>
                <a href="{{ route('leaderboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-semibold text-sm {{ request()->routeIs('leaderboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    <i class="fas fa-chart-simple w-5 text-center text-lg {{ request()->routeIs('leaderboard') ? 'text-blue-600' : 'text-slate-400' }}"></i> Reyting
                </a>
                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-semibold text-sm {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    <i class="fas fa-user w-5 text-center text-lg {{ request()->routeIs('profile') ? 'text-blue-600' : 'text-slate-400' }}"></i> Profil
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-50">
            <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name.'&background=2563eb&color=fff' }}" 
                         class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                    <div>
                        <p class="text-sm font-bold text-slate-700 leading-none">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-500 transition px-2">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">
        
        <header class="h-20 flex items-center justify-between px-6 md:px-10 shrink-0 bg-[#f8f9fa] z-30">
            
            <button onclick="toggleSidebar()" class="md:hidden w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center shadow-sm hover:text-blue-600 hover:border-blue-200 transition">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div class="flex-1"></div>

            <button class="w-10 h-10 rounded-full bg-white border border-slate-100 text-slate-400 hover:text-blue-600 shadow-sm flex items-center justify-center transition">
                <i class="fas fa-bell"></i>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto px-4 md:px-10 pb-12 w-full">
            @yield('content')
        </div>

    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            // Sidebar'ni surish
            sidebar.classList.toggle('-translate-x-full');
            
            // Overlay'ni ko'rsatish/yashirish
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300); // Animatsiya tugagach yashirish
            } else {
                overlay.classList.remove('hidden');
                // Kichik pauza bilan opacity ni o'zgartiramiz, animatsiya chiroyli bo'lishi uchun
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            }
        }
    </script>
</body>
</html>