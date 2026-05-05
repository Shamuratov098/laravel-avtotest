@extends('admin.layouts.app')

@section('title', 'Savolni Yangilash')

@section('content')

    {{-- Breadcrumb --}}
    <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px; font-size:13px; color:#8899A8;">
        <a href="{{ route('admin.questions.index') }}" style="color:#5750F1; text-decoration:none; font-weight:600;">Test
            Savollar</a>
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span>Tahrirlash — {{ $question->order_in_category }}</span>
    </div>

    <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

            {{-- ============================================================
                 CHAP USTUN
                 ============================================================ --}}
            <div style="display:flex; flex-direction:column; gap:20px;">

                {{-- Savol matni --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:24px;">
                    <h2 style="font-size:15px; font-weight:700; color:#1C2434; margin:0 0 20px;
                       padding-bottom:14px; border-bottom:1px solid #F3F4F6;">
                        Savol ma'lumotlari
                    </h2>

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
                                  onblur="this.style.borderColor='{{ $errors->has('question_text') ? '#DC2626' : '#E8EEF3' }}'">{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                        <p style="font-size:12px; color:#DC2626; margin:5px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:12px; font-weight:600; color:#637381; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em;">
                            Rasm <span style="color:#8899A8; font-weight:400;">(ixtiyoriy)</span>
                        </label>

                        {{-- Preview blok: mavjud rasm yoki yangi tanlangan rasm --}}
                        <div id="image-preview-wrapper"
                             style="display:{{ $question->image_src ? 'block' : 'none' }};
                                    padding:14px; background:#F7F9FC; border:1px solid #E8EEF3;
                                    border-radius:10px; margin-bottom:12px;">
                            <p id="image-preview-label" style="font-size:12px; color:#637381; margin:0 0 12px; font-weight:600;">
                                {{ $question->image_src ? 'Mavjud rasm' : 'Tanlangan rasm' }}
                            </p>
                            <div style="text-align:center; margin-bottom:12px;">
                                <img id="image-preview" src="{{ $question->image_src ?? '' }}" alt="Rasm"
                                     style="max-width:100%; max-height:420px; object-fit:contain; border-radius:8px;
                                            border:1px solid #E8EEF3; background:#fff;">
                            </div>
                            <label id="delete-image-row"
                                   style="display:{{ $question->image_src ? 'flex' : 'none' }};
                                          align-items:center; gap:8px; cursor:pointer; user-select:none;
                                          padding:8px 12px; background:#fff; border:1px solid #FECACA;
                                          border-radius:7px;">
                                <input type="checkbox" name="delete_image" value="1"
                                       {{ old('delete_image') ? 'checked' : '' }}
                                       style="width:16px; height:16px; accent-color:#DC2626; cursor:pointer;">
                                <span style="font-size:13px; color:#DC2626; font-weight:600;">Rasmni o'chirish</span>
                            </label>
                        </div>

                        <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp"
                               onchange="previewSelectedImage(this)"
                               style="width:100%; padding:9px 12px; border:1.5px dashed {{ $errors->has('image') ? '#DC2626' : '#E8EEF3' }};
                              border-radius:8px; font-size:13px; color:#1C2434; outline:none; box-sizing:border-box;
                              background:#F7F9FC; cursor:pointer;">
                        <p style="font-size:11px; color:#8899A8; margin:6px 0 0;">
                            @if($question->image_src)
                                Yangi rasm yuklasangiz, eski rasm almashtiriladi.
                            @else
                                JPG, PNG yoki WEBP. Maksimal 5 MB.
                            @endif
                        </p>
                        @error('image')
                        <p style="font-size:12px; color:#DC2626; margin:5px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Javob variantlari --}}
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
                        @php
                            $existingAnswers = old('answers')
                                ? collect(old('answers'))->map(fn($a) => (object)$a)
                                : $question->answers;
                            $correctVal = old('correct_answer', $question->correct_answer);
                        @endphp

                        @foreach($existingAnswers as $i => $answer)
                            @include('admin.question._answer_row', [
                                'index'         => $i,
                                'optionNumber'  => $answer->option_number ?? $answer['option_number'],
                                'answerText'    => $answer->answer_text   ?? $answer['answer_text'],
                                'correctAnswer' => $correctVal,
                            ])
                        @endforeach
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
                              onblur="this.style.borderColor='#E8EEF3'">{{ old('explanation', $question->explanation) }}</textarea>
                </div>
            </div>

            {{-- ============================================================
                 O'NG USTUN
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
                        Yangilash
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
                            style="width:100%; padding:10px 13px; border:1.5px solid {{ $errors->has('category_id') ? '#DC2626' : '#E8EEF3' }};
                           border-radius:8px; font-size:13px; color:#1C2434; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">— Kategoriyani tanlang —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $question->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p style="font-size:12px; color:#DC2626; margin:5px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Holat --}}
                <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6;
                    box-shadow:0 1px 4px rgba(0,0,0,.05); padding:20px;">
                    <h3 style="font-size:13px; font-weight:700; color:#1C2434; margin:0 0 14px;">Holat</h3>
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer; user-select:none;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $question->is_active) ? 'checked' : '' }}
                               style="width:40px; height:22px; appearance:none; border-radius:11px; cursor:pointer; transition:.2s;"
                               onchange="this.style.background = this.checked ? '#5750F1' : '#E8EEF3'">
                        <div>
                            <p style="font-size:13px; font-weight:600; color:#1C2434; margin:0;">Faol</p>
                            <p style="font-size:12px; color:#8899A8; margin:2px 0 0;">Savolni testda ko'rsatish</p>
                        </div>
                    </label>
                </div>

                {{-- ID info --}}
                <div style="padding:14px 16px; background:#F7F9FC; border-radius:10px; font-size:12px; color:#8899A8;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span>ID:</span>
                        <strong style="color:#1C2434;">{{ $question->id }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span>Yaratilgan:</span>
                        <strong style="color:#1C2434;">{{ $question->created_at?->format('d.m.Y') }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span>Yangilangan:</span>
                        <strong style="color:#1C2434;">{{ $question->updated_at?->format('d.m.Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- correct_answer FORM ICHIDA bo'lishi shart! --}}
        <input type="hidden" name="correct_answer" id="correct_answer"
               value="{{ old('correct_answer', $question->correct_answer) }}">

    </form>

    <script>
        let answerCount = {{ old('answers') ? count(old('answers')) : $question->answers->count() }};
        const labelMap = {1: 'A', 2: 'B', 3: 'C', 4: 'D', 5: 'E', 6: 'F'};

        function addAnswer() {
            if (answerCount >= 6) {
                alert('Maksimal 6 ta javob varianti bo\'lishi mumkin.');
                return;
            }
            const optionNumber = answerCount + 1;
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
            const formHidden = document.getElementById('correct_answer');
            if (formHidden) formHidden.value = optionNumber;

            document.querySelectorAll('.answer-row').forEach(row => {
                row.style.borderColor = '#E8EEF3';
                row.style.background = '#fff';
                const btn = row.querySelector('.correct-btn');
                if (btn) {
                    btn.style.background = '#F3F4F6';
                    btn.style.color = '#637381';
                }
            });

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
                margin-bottom:10px; background:#fff; transition:.2s;">
        <input type="hidden" name="answers[${index}][option_number]" value="${optionNumber}">
        <span style="display:flex; align-items:center; justify-content:center;
                     width:34px; height:34px; background:#F7F9FC; border-radius:8px;
                     font-size:13px; font-weight:700; color:#5750F1; flex-shrink:0;">${label}</span>
        <input type="text" name="answers[${index}][answer_text]" value="${value}"
               style="padding:9px 12px; border:1.5px solid #E8EEF3; border-radius:7px;
                      font-size:13px; color:#1C2434; outline:none; width:100%; box-sizing:border-box;"
               placeholder="${label} varianti matnini kiriting..."
               onfocus="this.style.borderColor='#5750F1'" onblur="this.style.borderColor='#E8EEF3'">
        <button type="button" class="correct-btn" onclick="setCorrect(${optionNumber})"
                style="display:inline-flex; align-items:center; gap:4px; padding:7px 11px;
                       background:#F3F4F6; color:#637381; border:none; border-radius:7px;
                       cursor:pointer; font-size:12px; font-weight:600; white-space:nowrap;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>To'g'ri</button>
        <button type="button" onclick="removeAnswer(${index})"
                style="display:flex; align-items:center; justify-content:center; width:32px; height:32px;
                       background:#FEF2F2; color:#DC2626; border:none; border-radius:7px; cursor:pointer; flex-shrink:0;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg></button>
    </div>`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const cb = document.getElementById('is_active');
            if (cb) cb.style.background = cb.checked ? '#5750F1' : '#E8EEF3';

            const correctVal = parseInt('{{ old('correct_answer', $question->correct_answer) }}');
            if (correctVal) setCorrect(correctVal);
        });

        const originalImageSrc = @json($question->image_src);
        const hasOriginalImage = !!originalImageSrc;

        function previewSelectedImage(input) {
            const wrapper = document.getElementById('image-preview-wrapper');
            const img = document.getElementById('image-preview');
            const label = document.getElementById('image-preview-label');
            const deleteRow = document.getElementById('delete-image-row');
            const file = input.files && input.files[0];

            if (!file) {
                // Tanlovni bekor qildi: asl holatga qaytamiz
                if (hasOriginalImage) {
                    img.src = originalImageSrc;
                    label.textContent = 'Mavjud rasm';
                    deleteRow.style.display = 'flex';
                    wrapper.style.display = 'block';
                } else {
                    wrapper.style.display = 'none';
                    img.src = '';
                }
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
                label.textContent = 'Yangi tanlangan rasm';
                deleteRow.style.display = 'none';
                wrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    </script>

@endsection
