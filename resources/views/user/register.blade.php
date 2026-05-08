<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ro'yxatdan o'tish | Avtotest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans antialiased">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100 animate-fade-in my-8">
        
        <!-- Sarlavha -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Yangi hisob yaratish</h1>
            <p class="text-slate-500 font-medium mt-2">Haydovchilik guvohnomasi tomon ilk qadam!</p>
        </div>

        <!-- Forma -->
        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Ism -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Ism va Familiya</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Sardor Bekmurodov" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
                @error('name')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telefon raqam -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Telefon raqam</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">+998</span>
                    <!-- pl-14 orqali textni +998 dan keyinga suramiz -->
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="901234567" maxlength="9" class="w-full pl-14 pr-4 py-3 rounded-xl border {{ $errors->has('phone') ? 'border-red-300 bg-red-50' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
                </div>
                @error('phone')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email manzil</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="ism@misol.uz" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
                @error('email')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parol -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Parol</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
                @error('password')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parolni tasdiqlash -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Parolni takrorlang</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition text-slate-800 font-medium">
            </div>

            <!-- Tugma -->
            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3.5 rounded-xl transition-all shadow-md mt-6">
                Ro'yxatdan o'tish
            </button>
        </form>

        <!-- Loginga o'tish -->
        <p class="text-center text-slate-500 font-medium mt-8">
            Allaqachon hisobingiz bormi? 
            <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Kirish</a>
        </p>

    </div>

</body>
</html>