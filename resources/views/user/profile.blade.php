@extends('user.layouts.dashboard-layout')

@section('title', 'Profil | Avtotest')

@section('content')
<div class="max-w-3xl mx-auto pb-12 animate-fade-in">

    <!-- Sarlavha -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Shaxsiy ma'lumotlar</h1>
        <p class="text-slate-500 font-medium mt-1">Profilingizni tahrirlang va rasmingizni yangilang.</p>
    </div>

    <!-- Muvaffaqiyat xabari (Backenddan Session orqali keladi) -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6 font-medium flex items-center gap-2 shadow-sm">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Asosiy Forma -->
    <!-- enctype="multipart/form-data" rasm yuborish uchun shart! -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm space-y-8">
        @csrf
        @method('PUT') <!-- Laravel uchun Update formati -->

        <!-- 1. Rasm yuklash qismi -->
        <div class="flex flex-col sm:flex-row items-center gap-6 pb-8 border-b border-slate-100">
            <!-- Hozirgi rasm yoki default avatarni ko'rsatish -->
            <div class="relative w-24 h-24 rounded-2xl border-4 border-slate-50 shadow-sm overflow-hidden flex-shrink-0 bg-slate-100">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" class="w-full h-full object-cover">
            </div>
            
            <div class="text-center sm:text-left w-full">
                <label class="block text-sm font-bold text-slate-700 mb-2">Profil rasmini yangilash</label>
                <!-- Sodda fayl tanlash tugmasi -->
                <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg" class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2.5 file:px-4
                    file:rounded-xl file:border-0
                    file:text-sm file:font-bold
                    file:bg-blue-50 file:text-blue-600
                    hover:file:bg-blue-100 transition cursor-pointer border border-slate-200 rounded-xl p-1">
                
                <p class="text-xs text-slate-400 mt-2 font-medium">Tavsiya etilgan formatlar: JPG, PNG. Maksimal hajm: 2MB.</p>
                
                <!-- Backenddan kelgan rasm xatolari -->
                @error('avatar')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 2. Shaxsiy ma'lumotlar qismi -->
        <div class="grid grid-cols-1 gap-6">
            
            <!-- Ism -->
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Ism va Familiya</label>
                <!-- value ichiga bazadagi ma'lumotni yoki xato bo'lganda user tergan matnni (old('name')) qo'yamiz -->
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-slate-800 font-medium">
                
                @error('name')
                    <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (O'zgartirib bo'lmaydi) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center justify-between">
                    Email manzil <span class="text-[10px] uppercase bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md">O'zgartirib bo'lmaydi</span>
                </label>
                <!-- disabled xususiyati orqali formaga yozishni taqiqlaymiz -->
                <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 font-medium cursor-not-allowed">
            </div>

        </div>

        <!-- 3. Saqlash tugmasi -->
        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md w-full sm:w-auto">
                O'zgarishlarni saqlash
            </button>
        </div>

    </form>
</div>
@endsection