@extends('layouts.dashboard-layout')

@section('title', 'Avtotest - Profil')

@section('content')
<div class="max-w-2xl mx-auto py-8 animate-fade-in">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl mb-8 text-center text-sm font-bold border border-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="flex flex-col items-center">
            <div class="relative group cursor-pointer">
                <img id="preview" 
                     src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name.'&background=3b82f6&color=fff&size=200' }}" 
                     class="w-28 h-28 rounded-full object-cover shadow-lg border-4 border-white transition-transform group-hover:scale-105">
                
                <label for="avatar" class="absolute inset-0 bg-slate-900/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                    <i class="fas fa-camera text-white text-xl"></i>
                    <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)">
                </label>
            </div>
            
            <h2 class="text-2xl font-extrabold text-slate-800 mt-5">{{ auth()->user()->name }}</h2>
        </div>

        <div>
            <h3 class="flex items-center gap-2 font-bold text-slate-800 text-lg mb-6">
                <i class="far fa-user text-blue-500"></i> Profil ma'lumotlari
            </h3>
            
            <div class="space-y-5 pl-1">
                <div>
                    <label class="block text-[13px] font-semibold text-slate-500 mb-2">Ismingiz</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" 
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-500 mb-2">Elektron pochta manzilingiz</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" disabled
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-400 cursor-not-allowed outline-none">
                    <p class="text-xs text-slate-400 mt-1.5"><i class="fas fa-info-circle"></i> Email manzilini o'zgartirib bo'lmaydi.</p>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <h3 class="flex items-center gap-2 font-bold text-slate-800 text-lg mb-6">
                <i class="fas fa-cog text-blue-500"></i> Hisob sozlamalari
            </h3>
            
            
        </div>

        <div class="flex flex-col items-center pt-8">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold text-sm px-8 py-3.5 rounded-full shadow-lg shadow-blue-200 hover:-translate-y-0.5 transition-all w-full md:w-auto min-w-[250px]">
                O'zgarishlarni saqlash
            </button>
            
            <a href="#" class="mt-6 text-sm font-semibold text-slate-400 hover:text-red-500 transition border-b border-transparent hover:border-red-500">
                Hisobingizni o'chirish
            </a>
        </div>

    </form>
</div>

<script>
    // Rasmni darhol ko'rsatish
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection