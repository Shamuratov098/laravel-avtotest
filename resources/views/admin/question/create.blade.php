@extends('admin.layouts.app')

@section('title', 'Yangi Savol Qo\'shish')

@section('content')

    {{-- Breadcrumb --}}
    <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px; font-size:13px; color:#8899A8;">
        <a href="{{ route('admin.questions.index') }}" style="color:#5750F1; text-decoration:none; font-weight:600;">Test
            Savollar</a>
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span>Yangi Savol</span>
    </div>

    <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

            {{-- ============================================================
                 CHAP USTUN: Asosiy ma'lumotlar
                 ============================================================ --}}
            <div style="display:flex; flex-direction:column; gap:20px;">

                {{-- Savol matni --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:24px;">
                    <h2 style="font-size:15px; font-weight:700; color:#1C2434; margin:0 0 20px;
                       padding-bottom:14px; border-bottom:1px solid #F3F4F6;">
                        Savol ma'lumotlari
                    </h2>

                    {{-- Savol matni --}}
                    <div style="margin-bottom:18px;">
                        <label
                            style="display:block; font-size:12px; font-weight:600; color:#637381; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em;">
                            Savol matni <span style="color:#DC2626;">*</span>
                        </label>
                        <textarea name="question_text" rows="4"
                                  style="width:100%; padding:11px 14px; border:1.5px solid {{ $errors->has('question_text') ? '#DC2626' : '#E8EEF3' }};
                                 border-radius:8px; font-size:13px; color:#1C2434; resize:vertical;
                                 outline:none; transition:border-color .2s; box-sizing:border-box; line-height:1.6;"
                                  placeholder="Savol matnini kiriting..."
                                  onfocus="this.style.borderColor='#5750F1'"
                                  onblur="this.style.borderColor='{{ $errors->has('question_text') ? '#DC2626' : '#E8EEF3' }}'">{{ old('question_text') }}</textarea>
                        @error('question_text')
                        <p style="font-size:12px; color:#DC2626; margin:5px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rasm yuklash --}}
                    <div>
                        <label
                            style="display:block; font-size:12px; font-weight:600; color:#637381; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em;">
                            Rasm <span style="color:#8899A8; font-weight:400;">(ixtiyoriy)</span>
                        </label>

                        <div id="image-preview-wrapper" style="display:none; padding:14px; background:#F7F9FC;
                                    border:1px solid #E8EEF3; border-radius:10px; margin-bottom:12px; text-align:center;">
                            <p style="font-size:12px; color:#637381; margin:0 0 12px; text-align:left; font-weight:600;">
                                Tanlangan rasm
                            </p>
                            <img id="image-preview" src="" alt="Tanlangan rasm"
                                 style="max-width:100%; max-height:420px; border-radius:8px; border:1px solid #E8EEF3;
                                        object-fit:contain; background:#fff;">
                        </div>

                        <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp"
                               onchange="previewSelectedImage(this)"
                               style="width:100%; padding:9px 12px; border:1.5px dashed {{ $errors->has('image') ? '#DC2626' : '#E8EEF3' }};
                              border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box;
                              background:#F7F9FC; cursor:pointer;">
                        <p style="font-size:11px; color:#8899A8; margin:6px 0 0;">JPG, PNG yoki WEBP. Maksimal 5 MB.</p>
                        @error('image')
                        <p style="font-size:12px; color:#DC2626; margin:5px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ============================================================
                     JAVOB VARIANTLARI
                     ============================================================ --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:24px;">

                    <div
                        style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; padding-bottom:14px; border-bottom:1px solid #F3F4F6;">
                        <h2 style="font-size:15px; font-weight:700; color:#1C2434; margin:0;">
                            Javob variantlari
                        </h2>
                        <button type="button" onclick="addAnswer()"
                                style="display:inline-flex; align-items:center; gap:5px; padding:7px 13px;
                               background:#F0F4FF; color:#5750F1; border:none; border-radius:7px;
                               cursor:pointer; font-size:12px; font-weight:600;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Variant qo'shish
                        </button>
                    </div>

                    @error('answers')
                    <div
                        style="padding:10px 14px; background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; margin-bottom:16px; font-size:12px; color:#DC2626;">
                        {{ $message }}
                    </div>
                    @enderror
                    @error('correct_answer')
                    <div
                        style="padding:10px 14px; background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; margin-bottom:16px; font-size:12px; color:#DC2626;">
                        {{ $message }}
                    </div>
                    @enderror

                    {{-- Hint --}}
                    <div style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#F0FDF4;
                        border-radius:8px; margin-bottom:18px; font-size:12px; color:#15803D;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        To'g'ri javobni <strong style="margin:0 3px;">✓</strong> tugmachasi orqali belgilang
                    </div>

                    <div id="answers-container">
                        {{-- Old data bor bo'lsa uni qayta ko'rsatish --}}
                        @if(old('answers'))
                            @foreach(old('answers') as $i => $oldAnswer)
                                @include('admin.question._answer_row', [
                                    'index'          => $i,
                                    'optionNumber'   => $oldAnswer['option_number'],
                                    'answerText'     => $oldAnswer['answer_text'],
                                    'correctAnswer'  => old('correct_answer'),
                                ])
                            @endforeach
                        @else
                            {{-- Default 4 ta variant: option_number = 1,2,3,4 (integer) --}}
                            @foreach([1, 2, 3, 4] as $i => $num)
                                @include('admin.question._answer_row', [
                                    'index'          => $i,
                                    'optionNumber'   => $num,
                                    'answerText'     => '',
                                    'correctAnswer'  => old('correct_answer'),
                                ])
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Izoh --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:24px;">
                    <h2 style="font-size:15px; font-weight:700; color:#1C2434; margin:0 0 16px;
                       padding-bottom:14px; border-bottom:1px solid #F3F4F6;">
                        Izoh <span style="font-size:12px; color:#8899A8; font-weight:400;">(ixtiyoriy)</span>
                    </h2>
                    <textarea name="explanation" rows="3"
                              style="width:100%; padding:11px 14px; border:1.5px solid #E8EEF3; border-radius:8px;
                             font-size:13px; color:#1C2434; resize:vertical; outline:none; box-sizing:border-box; line-height:1.6;"
                              placeholder="To'g'ri javobni tushuntirish..."
                              onfocus="this.style.borderColor='#5750F1'"
                              onblur="this.style.borderColor='#E8EEF3'">{{ old('explanation') }}</textarea>
                </div>
            </div>

            {{-- ============================================================
                 O'NG USTUN: Sozlamalar
                 ============================================================ --}}
            <div style="display:flex; flex-direction:column; gap:20px;">

                {{-- Amallar --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:20px;">
                    <h3 style="font-size:13px; font-weight:700; color:#1C2434; margin:0 0 16px;">Amallar</h3>

                    <button type="submit"
                            style="display:flex; align-items:center; justify-content:center; gap:7px; width:100%;
                           padding:11px; background:#5750F1; color:#fff; border:none; border-radius:8px;
                           cursor:pointer; font-size:13px; font-weight:700; margin-bottom:10px;"
                            onmouseover="this.style.background='#4740D4'"
                            onmouseout="this.style.background='#5750F1'">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Saqlash
                    </button>

                    <a href="{{ route('admin.questions.index') }}"
                       style="display:flex; align-items:center; justify-content:center; gap:7px; width:100%;
                      padding:11px; background:#F7F9FC; color:#637381; border-radius:8px;
                      text-decoration:none; font-size:13px; font-weight:600; box-sizing:border-box;">
                        Bekor qilish
                    </a>
                </div>

                {{-- Kategoriya --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:20px;">
                    <label
                        style="display:block; font-size:12px; font-weight:600; color:#637381; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em;">
                        Kategoriya <span style="color:#DC2626;">*</span>
                    </label>
                    <select name="category_id"
                            style="width:100%; padding:10px 13px;
                   border:1.5px solid {{ $errors->has('category_id') ? '#DC2626' : '#E8EEF3' }};
                   border-radius:8px; font-size:13px; color:#1C2434; outline:none;
                   background:#fff; box-sizing:border-box;">
                        <option value="">— Kategoriyani tanlang —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                                ({{ $category->questions_count }}/10) {{-- qancha qolganini ko'rsatish --}}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                    <div style="display:flex; align-items:flex-start; gap:8px; margin-top:10px;
                    padding:12px 14px; background:#FEF2F2; border:1px solid #FECACA;
                    border-radius:8px;">
                        <svg style="flex-shrink:0; margin-top:1px;" width="15" height="15" fill="none"
                             stroke="#DC2626" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <p style="font-size:12px; color:#DC2626; margin:0; line-height:1.5;">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                {{-- Tartib raqami --}}
                {{--<div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:20px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#637381; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em;">
                        Tartib raqami <span style="color:#DC2626;">*</span>
                    </label>
                    <input type="number" name="order_in_category" value="{{ old('order_in_category', 1) }}" min="1"
                           style="width:100%; padding:10px 13px; border:1.5px solid {{ $errors->has('order_in_category') ? '#DC2626' : '#E8EEF3' }};
                          border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box;"
                           onfocus="this.style.borderColor='#5750F1'"
                           onblur="this.style.borderColor='{{ $errors->has('order_in_category') ? '#DC2626' : '#E8EEF3' }}'">
                    @error('order_in_category')
                    <p style="font-size:12px; color:#DC2626; margin:5px 0 0;">{{ $message }}</p>
                    @enderror
                </div>--}}

                {{-- Holat --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:20px;">
                    <h3 style="font-size:13px; font-weight:700; color:#1C2434; margin:0 0 14px;">Holat</h3>
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer; user-select:none;">
                        <div style="position:relative;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   style="width:40px; height:22px; appearance:none; background:#E8EEF3;
                                  border-radius:11px; cursor:pointer; transition:.2s; position:relative;"
                                   onchange="this.style.background = this.checked ? '#5750F1' : '#E8EEF3'">
                        </div>
                        <div>
                            <p style="font-size:13px; font-weight:600; color:#1C2434; margin:0;">Faol</p>
                            <p style="font-size:12px; color:#8899A8; margin:2px 0 0;">Savolni testda ko'rsatish</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- correct_answer FORM ICHIDA bo'lishi shart! --}}
        <input type="hidden" name="correct_answer" id="correct_answer" value="{{ old('correct_answer') }}">

    </form>

    {{-- ================================================================
         JAVASCRIPT — dinamik javob qo'shish
         ================================================================ --}}
    <script>
        let answerCount = {{ old('answers') ? count(old('answers')) : 4 }};

        // DB da integer saqlanadi, UI da harf ko'rsatiladi
        const labelMap = {1: 'A', 2: 'B', 3: 'C', 4: 'D', 5: 'E', 6: 'F'};

        function addAnswer() {
            if (answerCount >= 6) {
                alert('Maksimal 6 ta javob varianti bo\'lishi mumkin.');
                return;
            }

            const optionNumber = answerCount + 1; // integer: 1,2,3,4,5,6
            const label = labelMap[optionNumber] ?? optionNumber;
            const container = document.getElementById('answers-container');
            const div = document.createElement('div');
            div.innerHTML = buildAnswerRow(answerCount, optionNumber, label, '');
            container.appendChild(div.firstElementChild);
            answerCount++;
        }

        function removeAnswer(index) {
            const row = document.getElementById('answer-row-' + index);
            if (row) row.remove();
        }

        function setCorrect(optionNumber) {
            // integer qiymatni hidden field ga yozish
            document.getElementById('correct_answer').value = optionNumber;

            // Barcha rowlarni reset
            document.querySelectorAll('.answer-row').forEach(row => {
                row.style.borderColor = '#E8EEF3';
                row.style.background = '#fff';
                const btn = row.querySelector('.correct-btn');
                if (btn) {
                    btn.style.background = '#F3F4F6';
                    btn.style.color = '#637381';
                }
            });

            // Tanlanganni highlight
            const selected = document.querySelector('[data-option="' + optionNumber + '"]');
            if (selected) {
                selected.style.borderColor = '#6EE7B7';
                selected.style.background = '#F0FDF4';
                const btn = selected.querySelector('.correct-btn');
                if (btn) {
                    btn.style.background = '#DCFCE7';
                    btn.style.color = '#16A34A';
                }
            }
        }

        function buildAnswerRow(index, optionNumber, label, value) {
            return `
    <div id="answer-row-${index}" class="answer-row" data-option="${optionNumber}"
         style="display:grid; grid-template-columns:38px 1fr auto auto; gap:10px; align-items:center;
                padding:12px 14px; border:1.5px solid #E8EEF3; border-radius:10px;
                margin-bottom:10px; transition:.2s; background:#fff;">

        <input type="hidden" name="answers[${index}][option_number]" value="${optionNumber}">

        <span style="display:flex; align-items:center; justify-content:center;
                     width:34px; height:34px; background:#F7F9FC; border-radius:8px;
                     font-size:13px; font-weight:700; color:#5750F1; flex-shrink:0;">
            ${label}
        </span>

        <input type="text" name="answers[${index}][answer_text]" value="${value}"
               style="padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:7px;
                      font-size:13px; color:#1C2434; outline:none; width:100%; box-sizing:border-box;"
               placeholder="${label} varianti matnini kiriting..."
               onfocus="this.style.borderColor='#5750F1'"
               onblur="this.style.borderColor='#E8EEF3'">

        <button type="button" class="correct-btn" onclick="setCorrect(${optionNumber})"
                style="display:inline-flex; align-items:center; gap:4px; padding:7px 11px;
                       background:#F3F4F6; color:#637381; border:none; border-radius:7px;
                       cursor:pointer; font-size:12px; font-weight:600; white-space:nowrap;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            To'g'ri
        </button>

        <button type="button" onclick="removeAnswer(${index})"
                style="display:flex; align-items:center; justify-content:center;
                       width:32px; height:32px; background:#FEF2F2; color:#DC2626;
                       border:none; border-radius:7px; cursor:pointer; flex-shrink:0;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const cb = document.getElementById('is_active');
            if (cb) cb.style.background = cb.checked ? '#5750F1' : '#E8EEF3';

            // Old correct_answer ni highlight qilish (integer)
            const correctVal = parseInt(document.getElementById('correct_answer')?.value);
            if (correctVal) setCorrect(correctVal);
        });

        function previewSelectedImage(input) {
            const wrapper = document.getElementById('image-preview-wrapper');
            const img = document.getElementById('image-preview');
            const file = input.files && input.files[0];

            if (!file) {
                wrapper.style.display = 'none';
                img.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
                wrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    </script>

@endsection
