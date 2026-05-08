<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tizimga kirish | Avtotest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans antialiased">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100 animate-fade-in">
        
        <!-- Logotip -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fas fa-steering-wheel"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Avtotestga xush kelibsiz!</h1>
            <p class="text-slate-500 font-medium mt-2">Boshqaruv paneliga kirish uchun ma'lumotlaringizni kiriting.</p>
        </div>

        <!-- Forma -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf <!-- Laravel xavfsizlik tokeni (Shart!) -->

            <!-- Email -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email manzil</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="ism@misol.uz" class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-slate-200 focus:border-blue-500' }} focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parol -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Parol</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
                </div>
            </div>

            <!-- Tugma -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md mt-4">
                Tizimga kirish
            </button>
        </form>

        <!-- Registratsiyaga o'tish -->
        <p class="text-center text-slate-500 font-medium mt-8">
            Hali hisobingiz yo'qmi? 
            <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Ro'yxatdan o'tish</a>
        </p>

    </div>

</body>
</html>