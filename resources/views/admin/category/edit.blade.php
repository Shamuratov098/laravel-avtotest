@extends('admin.layouts.app')

@section('title', 'Kategoriyani Yangilash')

@section('content')

    <!-- Breadcrumb -->
    <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px; font-size:13px;">
        <a href="{{ route('admin.categories.index') }}" style="color:#5750F1; text-decoration:none; font-weight:500;">Kategoriyalar</a>
        <svg width="14" height="14" fill="none" stroke="#8899A8" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span style="color:#8899A8;">{{ $category->name }}</span>
        <svg width="14" height="14" fill="none" stroke="#8899A8" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span style="color:#8899A8;">Yangilash</span>
    </div>

    <!-- Form Card -->
    <div style="max-width:600px;">
        <div
            style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden;">

            <!-- Card Header -->
            <div style="padding:20px 24px; border-bottom:1px solid #F3F4F6;">
                <h2 style="font-size:15px; font-weight:700; color:#1C2434; margin:0 0 2px;">Kategoriya ma'lumotlari</h2>
                <p style="font-size:12px; color:#8899A8; margin:0;">Kategoriya malumotlarini yangilang</p>
            </div>

            <!-- Info Box -->
            <div
                style="margin:16px 24px 0; padding:12px 16px; background:#EEF2FF; border-radius:8px; display:flex; align-items:center; gap:10px;">
                <svg width="16" height="16" fill="none" stroke="#5750F1" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span style="font-size:12px; color:#5750F1; font-weight:500;">
                Bu kategoriyada <strong>{{ $category->total_questions }}</strong> ta test savoli mavjud.
            </span>
            </div>

            <!-- Card Body -->
            <div style="padding:24px;">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div style="margin-bottom:20px;">
                        <label for="name"
                               style="display:block; font-size:13px; font-weight:600; color:#1C2434; margin-bottom:8px;">
                            Kategoriya Nomi <span style="color:#EF4444;">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            required
                            placeholder="1-variant"
                            style="width:100%; padding:10px 14px; border:1.5px solid #E8E8E8; border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box; transition:border .2s;"
                            onfocus="this.style.borderColor='#5750F1'" onblur="this.style.borderColor='#E8E8E8'"
                        >
                        @error('name')
                        <p style="margin:6px 0 0; font-size:12px; color:#EF4444;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- order Field -->
                    <div style="margin-bottom:24px;">
                        <label for="order"
                               style="display:block; font-size:13px; font-weight:600; color:#1C2434; margin-bottom:8px;">
                            Tartib Raqami <span style="font-size:12px; color:#8899A8; font-weight:400;"></span>
                        </label>
                        <div style="position:relative;">
                            <input
                                type="number"
                                name="order"
                                value="{{ old('order', $category->order) }}"
                                placeholder="1"
                                style="width:100%; padding:10px 100px 10px 14px; border:1.5px solid #E8E8E8; border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box; background:#F7F9FC;"
                                onfocus="this.style.borderColor='#5750F1'" onblur="this.style.borderColor='#E8E8E8'"
                            >
                        </div>
                        @error('order')
                        <p style="margin:6px 0 0; font-size:12px; color:#EF4444;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div
                        style="display:flex; align-items:center; justify-content:flex-end; gap:12px; padding-top:20px; border-top:1px solid #F3F4F6;">
                        <a href="{{ route('admin.categories.index') }}"
                           style="padding:9px 20px; border:1.5px solid #E8E8E8; color:#637381; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; transition:all .2s;">
                            Bekor qilish
                        </a>
                        <button type="submit"
                                style="padding:9px 20px; background:#5750F1; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:background .2s;">
                            Saqlash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
