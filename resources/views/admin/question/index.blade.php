@extends('admin.layouts.app')

@section('title', 'TEST SAVOLLAR')

@section('content')

    {{-- Flash xabarlar --}}
    @if(session('success'))
        <div style="margin-bottom:16px; padding:14px 18px; background:#ECFDF5; border:1px solid #6EE7B7; border-radius:10px;
                display:flex; align-items:center; gap:10px; font-size:13px; color:#065F46; font-weight:500;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <div><p style="font-size:13px; color:#8899A8; margin:4px 0 0;">
                Jami: <strong>{{ $questions->total() }}</strong> ta savol
            </p>
        </div>
        <a href="{{ route('admin.questions.create') }}"
           style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:#5750F1;
              color:#fff; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Yangi Savol
        </a>
    </div>

    {{-- Filterlar --}}
    @php $hasFilter = !empty(array_filter($filters)); @endphp
    <form method="GET" action="{{ route('admin.questions.index') }}"
          style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06);
                 padding:16px 20px; margin-bottom:20px;">
        <div
            style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px; align-items:end;">

            {{-- Kategoriya --}}
            <div>
                <label style="display:block; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase;
                              letter-spacing:.06em; margin-bottom:6px;">Kategoriya</label>
                <select name="category_id"
                        style="width:100%; padding:9px 12px; border:1px solid #E5E7EB; border-radius:8px;
                               background:#fff; font-size:13px; color:#1C2434; cursor:pointer;">
                    <option value="">Hammasi</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ ($filters['category_id'] ?? null) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Holat --}}
            <div>
                <label style="display:block; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase;
                              letter-spacing:.06em; margin-bottom:6px;">Holat</label>
                <select name="status"
                        style="width:100%; padding:9px 12px; border:1px solid #E5E7EB; border-radius:8px;
                               background:#fff; font-size:13px; color:#1C2434; cursor:pointer;">
                    <option value="">Hammasi</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Nofaol
                    </option>
                </select>
            </div>

            {{-- Qidiruv --}}
            <div style="grid-column: span 2;">
                <label style="display:block; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase;
                              letter-spacing:.06em; margin-bottom:6px;">Savol matni qidiruv</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       placeholder="Savol matnidan qidirish..."
                       style="width:100%; padding:9px 12px; border:1px solid #E5E7EB; border-radius:8px;
                              background:#fff; font-size:13px; color:#1C2434;">
            </div>

            {{-- Tugmalar --}}
            <div style="display:flex; gap:8px;">
                <button type="submit"
                        style="flex:1; padding:9px 16px; background:#5750F1; color:#fff; border:none; border-radius:8px;
                               font-size:13px; font-weight:600; cursor:pointer; white-space:nowrap;">
                    Filtrlash
                </button>
                @if($hasFilter)
                    <a href="{{ route('admin.questions.index') }}"
                       style="padding:9px 14px; background:#F3F4F6; color:#637381; border-radius:8px;
                              text-decoration:none; font-size:13px; font-weight:600; white-space:nowrap;
                              display:inline-flex; align-items:center;">
                        Tozalash
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Table Card --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
            box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr style="background:#F7F9FC; border-bottom:2px solid #F3F4F6;">
                    <th style="padding:12px 20px; text-align:center; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap; width:80px;">
                        №
                    </th>
                    <th style="padding:12px 12px; text-align:center; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; width:80px;">
                        Rasm
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap;">
                        Kategoriya
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Savol
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                        Javob variantlari
                    </th>
                    <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap;">
                        Holat
                    </th>
                    <th style="padding:12px 20px; text-align:right; font-size:11px; font-weight:700; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap;">
                        Amallar
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($questions as $question)
                    <tr style="border-top:1px solid #F3F4F6; transition:background .15s;"
                        onmouseover="this.style.background='#FAFBFF'" onmouseout="this.style.background='#fff'">

                        {{-- № --}}
                        <td style="padding:16px 20px; text-align:center;">
                            <span style="display:inline-flex; align-items:center; justify-content:center;
                                         width:32px; height:32px; background:#EEF2FF; border-radius:8px;
                                         font-size:12px; font-weight:700; color:#5750F1;">
                                {{ $question->order_in_category }}
                            </span>
                        </td>

                        {{-- Rasm --}}
                        <td style="padding:16px 12px; text-align:center;">
                            @if($question->image_src)
                                <img src="{{ $question->image_src }}" alt="Rasm"
                                     style="width:56px; height:56px; object-fit:cover; border-radius:6px;
                                            border:1px solid #E8EEF3; vertical-align:middle;"
                                     loading="lazy"
                                     onerror="this.style.display='none'">
                            @else
                                <span style="display:inline-flex; align-items:center; justify-content:center;
                                             width:56px; height:56px; background:#F7F9FC; border:1px dashed #E8EEF3;
                                             border-radius:6px; color:#C5CDD6;">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                            @endif
                        </td>

                        {{-- Kategoriya --}}
                        <td style="padding:16px 16px;">
                            <span style="display:inline-block; padding:4px 10px; background:#F0FDF4;
                                         color:#15803D; border-radius:6px; font-size:12px; font-weight:600; white-space:nowrap;">
                                {{ $question->category?->name ?? '—' }}
                            </span>
                        </td>

                        {{-- Savol --}}
                        <td style="padding:16px 16px; max-width:320px;">
                            <p style="font-size:13px; font-weight:600; color:#1C2434; margin:0;
                                      display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
                                      overflow:hidden; line-height:1.5;">
                                {{ $question->question_text }}
                            </p>
                        </td>

                        {{-- Javob variantlari --}}
                        <td style="padding:16px 16px;">
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                @foreach($question->answers as $answer)
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        {{-- To'g'ri javobni highlight qilish --}}
                                        @php $isCorrect = $answer->option_number === $question->correct_answer; @endphp
                                        <span style="display:inline-flex; align-items:center; justify-content:center;
                                                 width:22px; height:22px; border-radius:5px; font-size:11px; font-weight:700;
                                                 flex-shrink:0;
                                                 {{ $isCorrect ? 'background:#DCFCE7; color:#16A34A;' : 'background:#F3F4F6; color:#637381;' }}">
                                        {{ $answer->option_number }}
                                    </span>
                                        <span
                                            style="font-size:12px; {{ $isCorrect ? 'color:#16A34A; font-weight:600;' : 'color:#637381;' }}">
                                        {{ Str::limit($answer->answer_text, 40) }}
                                    </span>
                                        @if($isCorrect)
                                            <svg width="13" height="13" fill="none" stroke="#16A34A" stroke-width="2.5"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        {{-- Holat --}}
                        <td style="padding:16px 16px; text-align:center;">
                            <form action="{{ route('admin.questions.toggle-active', $question) }}" method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('PATCH')
                                @if($question->is_active)
                                    <button type="submit" title="Nofaol qilish"
                                            style="display:inline-flex; align-items:center; gap:5px; padding:4px 10px;
                                                   background:#DCFCE7; color:#16A34A; border:none; border-radius:20px;
                                                   font-size:11px; font-weight:700; cursor:pointer;">
                                        <span
                                            style="width:6px; height:6px; background:#16A34A; border-radius:50%;"></span>
                                        Faol
                                    </button>
                                @else
                                    <button type="submit" title="Faollashtirish"
                                            style="display:inline-flex; align-items:center; gap:5px; padding:4px 10px;
                                                   background:#F3F4F6; color:#637381; border:none; border-radius:20px;
                                                   font-size:11px; font-weight:700; cursor:pointer;">
                                        <span
                                            style="width:6px; height:6px; background:#9CA3AF; border-radius:50%;"></span>
                                        Nofaol
                                    </button>
                                @endif
                            </form>
                        </td>

                        {{-- Amallar --}}
                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px;">
                                <a href="{{ route('admin.questions.edit', $question) }}"
                                   style="display:inline-flex; align-items:center; gap:5px; padding:7px 12px;
                                      background:#EEF2FF; color:#5750F1; border-radius:7px; text-decoration:none;
                                      font-size:12px; font-weight:600; white-space:nowrap;"
                                   onmouseover="this.style.background='#dde4ff'"
                                   onmouseout="this.style.background='#EEF2FF'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Tahrirlash
                                </a>

                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                                      onsubmit="return confirm('Savolni o\'chirishni tasdiqlaysizmi?\nJavob variantlari ham o\'chib ketadi!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="display:inline-flex; align-items:center; gap:5px; padding:7px 12px;
                                               background:#FEF2F2; color:#DC2626; border-radius:7px; border:none;
                                               cursor:pointer; font-size:12px; font-weight:600; white-space:nowrap;"
                                            onmouseover="this.style.background='#fee2e2'"
                                            onmouseout="this.style.background='#FEF2F2'">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        O'chirish
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:64px; text-align:center;">
                            <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                                <div style="width:60px; height:60px; background:#F7F9FC; border-radius:14px;
                                        display:flex; align-items:center; justify-content:center;">
                                    <svg width="30" height="30" fill="none" stroke="#8899A8" stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                                @if($hasFilter)
                                    <p style="font-size:15px; font-weight:700; color:#1C2434; margin:0;">Hech narsa
                                        topilmadi</p>
                                    <p style="font-size:13px; color:#8899A8; margin:0;">Filtr shartlariga mos savol
                                        yo'q</p>
                                    <a href="{{ route('admin.questions.index') }}"
                                       style="margin-top:4px; display:inline-flex; align-items:center; gap:6px;
                                          padding:9px 18px; background:#F3F4F6; color:#637381; border-radius:8px;
                                          text-decoration:none; font-size:13px; font-weight:600;">
                                        Filterni tozalash
                                    </a>
                                @else
                                    <p style="font-size:15px; font-weight:700; color:#1C2434; margin:0;">Savollar
                                        topilmadi</p>
                                    <p style="font-size:13px; color:#8899A8; margin:0;">Birinchi savolni yarating</p>
                                    <a href="{{ route('admin.questions.create') }}"
                                       style="margin-top:4px; display:inline-flex; align-items:center; gap:6px;
                                          padding:9px 18px; background:#5750F1; color:#fff; border-radius:8px;
                                          text-decoration:none; font-size:13px; font-weight:600;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Yangi Savol Qo'shish
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($questions->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #F3F4F6;">
                {{ $questions->links() }}
            </div>
        @endif
    </div>

@endsection
