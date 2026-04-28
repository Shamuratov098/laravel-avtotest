{{--
    Parametrlar:
    $index         - massiv indeksi (0, 1, 2...)
    $optionNumber  - integer: 1, 2, 3, 4...  (DB ga saqlanadigan qiymat)
    $answerText    - javob matni
    $correctAnswer - integer: to'g'ri javobning option_number qiymati
--}}
@php
    // DB da 1,2,3,4 — UI da A,B,C,D
    $labelMap   = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F'];
    $label      = $labelMap[$optionNumber] ?? $optionNumber;
    $isCorrect  = isset($correctAnswer) && (int)$correctAnswer === (int)$optionNumber;
@endphp

<div id="answer-row-{{ $index }}" class="answer-row" data-option="{{ $optionNumber }}"
     style="display:grid; grid-template-columns:38px 1fr auto auto; gap:10px; align-items:center;
            padding:12px 14px; margin-bottom:10px; transition:.2s; border-radius:10px; border:1.5px solid;
            {{ $isCorrect ? 'border-color:#6EE7B7; background:#F0FDF4;' : 'border-color:#E8EEF3; background:#fff;' }}">

    {{-- DB ga integer saqlanadi --}}
    <input type="hidden" name="answers[{{ $index }}][option_number]" value="{{ $optionNumber }}">

    {{-- UI da harf ko'rsatiladi --}}
    <span style="display:flex; align-items:center; justify-content:center;
                 width:34px; height:34px; background:#F7F9FC; border-radius:8px;
                 font-size:13px; font-weight:700; color:#5750F1; flex-shrink:0;">
        {{ $label }}
    </span>

    {{-- Javob matni --}}
    <input type="text" name="answers[{{ $index }}][answer_text]" value="{{ $answerText }}"
           style="padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:7px;
                  font-size:13px; color:#1C2434; outline:none; width:100%; box-sizing:border-box;"
           placeholder="{{ $label }} varianti matnini kiriting..."
           onfocus="this.style.borderColor='#5750F1'"
           onblur="this.style.borderColor='#E8EEF3'">

    {{-- To'g'ri belgilash: integer qiymat uzatiladi --}}
    <button type="button" class="correct-btn" onclick="setCorrect({{ $optionNumber }})"
            style="display:inline-flex; align-items:center; gap:4px; padding:7px 11px; border:none;
                   border-radius:7px; cursor:pointer; font-size:12px; font-weight:600; white-space:nowrap;
                   {{ $isCorrect ? 'background:#DCFCE7; color:#16A34A;' : 'background:#F3F4F6; color:#637381;' }}">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        To'g'ri
    </button>

    {{-- O'chirish --}}
    <button type="button" onclick="removeAnswer({{ $index }})"
            style="display:flex; align-items:center; justify-content:center;
                   width:32px; height:32px; background:#FEF2F2; color:#DC2626;
                   border:none; border-radius:7px; cursor:pointer; flex-shrink:0;">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
