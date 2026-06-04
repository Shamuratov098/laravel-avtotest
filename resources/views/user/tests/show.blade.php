<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Test ishlash' }} | Avtotest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .correct-btn { border-color: #10b981 !important; background-color: #ecfdf5 !important; }
        .wrong-btn { border-color: #ef4444 !important; background-color: #fef2f2 !important; }
        .disabled-btn { pointer-events: none; opacity: 0.8; }
        .animate-pop { animation: pop 0.3s ease-out; }
        @keyframes pop {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen py-6 px-4">

    <div class="max-w-2xl mx-auto">
        <div class="bg-white p-4 rounded-2xl shadow-sm mb-6 flex justify-between items-center border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="bg-violet-100 text-violet-600 w-10 h-10 rounded-xl flex items-center justify-center font-bold" id="q-number-box">
                    {{-- F5 dan keyin qayerdan davom etishni PHP da hisoblaymiz --}}
                    {{ $answeredCount + 1 }}
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-tight" id="q-counter">
                        Savol {{ $answeredCount + 1 }}/{{ $questions->count() }}
                    </h2>
                    <p class="text-[11px] text-slate-400 font-medium">{{ $title ?? 'Test ishlash' }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div id="timer-box" class="flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-xl font-bold transition-colors shadow-sm">
                    <i class="fas fa-clock text-lg"></i>
                    <span id="timer-display" class="text-xl tracking-widest">--:--</span>
                </div>
            </div>

            <div class="text-right">
                {{-- F5 dan keyin to'g'ri javoblar sonini ham tiklaymiz --}}
                <span class="text-xs font-bold text-slate-400 block uppercase">To'g'ri: <span id="correct-stat" class="text-green-500">{{ $correctAnsweredCount }}</span></span>
            </div>
        </div>

        <div id="quiz-wrapper">
            @foreach($questions as $index => $q)
            {{--
                MANTIQ:
                - $answeredCount: backend'dan kelgan, shu sessiyada ishlab bo'lingan savollar soni.
                - Agar $index < $answeredCount bo'lsa => bu savol allaqachon ishlangan, uni yashiramiz.
                - Agar $index === $answeredCount bo'lsa => bu keyingi ishlanishi kerak bo'lgan savol, uni ochamiz.
                - Agar $index > $answeredCount bo'lsa => bu hali kelmagan savollar, ularni yashiramiz.
            --}}
            <div class="question-step {{ $index === $answeredCount ? '' : 'hidden' }} animate-pop"
                 id="step-{{ $index }}"
                 data-id="{{ $q->id }}"
                 data-correct="{{ $q->correct_answer }}">

                <div class="bg-white p-6 md:p-8 rounded-[32px] shadow-xl shadow-slate-200/50 border border-slate-100">

                    <h3 class="text-lg md:text-xl font-bold text-slate-800 leading-snug mb-6">
                        {{ $q->question_text }}
                    </h3>

                    @if($q->image_url)
                    <div class="mb-6 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 flex justify-center p-2">
                        <img src="{{ asset('storage/avatars/' . $q->image_url) }}"
                             alt="Savol rasmi"
                             class="max-w-full max-h-64 object-contain">
                    </div>
                    @endif

                    <div class="space-y-3" id="options-{{ $index }}">
                        @foreach($q->answers as $ans)
                        <button onclick="checkAnswer({{ $index }}, {{ $ans->option_number }})"
                                id="btn-{{ $index }}-{{ $ans->option_number }}"
                                class="w-full flex items-center p-4 border-2 border-slate-100 rounded-2xl hover:border-violet-200 hover:bg-violet-50 transition-all text-left group">
                            <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center mr-4 font-bold text-slate-400 group-hover:text-violet-600 group-hover:bg-violet-100 transition">
                                {{ $ans->option_number }}
                            </span>
                            <span class="text-slate-700 font-medium text-sm md:text-base">{{ $ans->answer_text }}</span>
                        </button>
                        @endforeach
                    </div>

                    <div id="feedback-{{ $index }}" class="mt-8 hidden">
                        <div id="alert-{{ $index }}" class="p-4 rounded-2xl mb-4 text-center font-black uppercase tracking-widest text-sm"></div>

                        <div class="bg-blue-50 p-5 rounded-2xl border-l-4 border-blue-500 mb-6">
                            <span class="text-[10px] font-black text-blue-500 uppercase block mb-1">Qoida bo'yicha tushuntirish:</span>
                            <p class="text-slate-700 text-sm leading-relaxed italic">
                                {{ $q->explanation }}
                            </p>
                        </div>

                        <button onclick="nextStep({{ $index }})" class="w-full py-4 bg-violet-600 text-white rounded-2xl font-bold shadow-lg shadow-violet-200 hover:bg-violet-700 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                            {{ $loop->last ? 'Natijani ko\'rish' : 'Keyingi savolga o\'tish' }}
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <div id="final-screen" class="hidden animate-pop bg-white p-10 rounded-[40px] shadow-2xl text-center border border-slate-100">
            <div class="w-24 h-24 bg-violet-100 text-violet-600 rounded-3xl flex items-center justify-center text-4xl mx-auto mb-6">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <h2 class="text-3xl font-black text-slate-800 mb-2">Test Yakunlandi!</h2>
            <div class="text-6xl font-black text-violet-600 mb-6" id="final-score">0/10</div>
            <p class="text-slate-400 mb-8 font-medium">Barcha natijalar statistika bo'limiga saqlandi.</p>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('tests.index') }}" class="py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">Yana ishlash</a>
                <a href="{{ route('dashboard') }}" class="py-4 bg-violet-600 text-white rounded-2xl font-bold hover:bg-violet-700 transition">Profilga qaytish</a>
            </div>
        </div>
    </div>

    <script>
        // ==========================================
        // BOSHLANG'ICH HOLAT (F5 dan keyin tiklanadi)
        // PHP o'zgaruvchilaridan JS ga o'tkazamiz
        // ==========================================
        let correctCount = {{ $correctAnsweredCount }}; // F5 dan keyin to'g'ri javoblar soni tiklanadi
        const total = {{ $questions->count() }};
        const sessionId = "{{ $testData['session']->id }}";
        const testType = "{{ $type }}";

        // ==========================================
        // TAYMER (BACKENDGA BOG'LANGAN — TEGMANG!)
        // ==========================================
        let timeLeft = {{ $timeLeft }};
        let timerInterval;

        window.onload = function() {
            if (timeLeft <= 0) {
                finishQuiz();
            } else {
                startTimer();
            }
        };

        function startTimer() {
            timerInterval = setInterval(function() {
                timeLeft--;

                let minutes = Math.floor(timeLeft / 60);
                let seconds = Math.floor(timeLeft % 60);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                document.getElementById('timer-display').innerText = minutes + ":" + seconds;

                if (timeLeft <= 60) {
                    let timerBox = document.getElementById('timer-box');
                    if (timerBox) {
                        timerBox.classList.remove('bg-blue-100', 'text-blue-700');
                        timerBox.classList.add('bg-red-100', 'text-red-700', 'animate-pulse');
                    }
                }

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    finishQuiz();
                }
            }, 1000);
        }

        // ==========================================
        // 1. AJAX ORQALI SAQLASH + 3. TUGMALARNI QULFLASH
        // ==========================================
        function checkAnswer(qIdx, selected) {
            const currentBox = document.getElementById(`step-${qIdx}`);
            const correct = parseInt(currentBox.dataset.correct);
            const feedback = document.getElementById(`feedback-${qIdx}`);
            const alertBox = document.getElementById(`alert-${qIdx}`);
            const questionId = currentBox.dataset.id;

            // --- 3. TUGMALARNI QULFLASH (Fail-safe) ---
            // Avval barcha onclick atributlarini olib tashlaymiz (ikki marta bosishdan himoya)
            // Keyin disabled klassini qo'shamiz
            const allBtns = document.querySelectorAll(`#options-${qIdx} button`);
            allBtns.forEach(btn => {
                btn.onclick = null;           // onclick handler'ni o'chiramiz
                btn.classList.add('disabled-btn'); // vizual qulflash
            });

            const isCorrect = (selected === correct);

            if (isCorrect) {
                correctCount++;
                document.getElementById(`btn-${qIdx}-${selected}`).classList.add('correct-btn');
                alertBox.innerHTML = "<i class='fas fa-check-circle mr-2'></i> To'g'ri javob!";
                alertBox.className = "p-4 rounded-2xl mb-4 text-center font-black uppercase tracking-widest text-sm bg-green-100 text-green-700";
            } else {
                document.getElementById(`btn-${qIdx}-${selected}`).classList.add('wrong-btn');
                document.getElementById(`btn-${qIdx}-${correct}`).classList.add('correct-btn');
                alertBox.innerHTML = "<i class='fas fa-times-circle mr-2'></i> Xato javob!";
                alertBox.className = "p-4 rounded-2xl mb-4 text-center font-black uppercase tracking-widest text-sm bg-red-100 text-red-700";
            }

            document.getElementById('correct-stat').innerText = correctCount;

            // "Keyingi savol" tugmasini DARHOL ko'rsatamiz (feedback bloki)
            feedback.classList.remove('hidden');
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });

            // --- 1. AJAX ORQALI BAZAGA SAQLASH ---
            // userAnswers massiviga push qilish o'rniga, to'g'ridan-to'g'ri fetch yuboramiz
            fetch("{{ route('tests.save_answer') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    question_id: questionId,
                    chosen_answer: selected,
                    is_correct: isCorrect ? 1 : 0
                })
            }).catch(function(err) {
                // Tarmoq xatosi bo'lsa konsol'ga yozamiz, lekin testni to'xtatmaymiz
                console.error('Javobni saqlashda xatolik:', err);
            });
        }

        function nextStep(qIdx) {
            if (qIdx + 1 < total) {
                document.getElementById(`step-${qIdx}`).classList.add('hidden');
                document.getElementById(`step-${qIdx + 1}`).classList.remove('hidden');
                document.getElementById('q-counter').innerText = `Savol ${qIdx + 2}/${total}`;
                document.getElementById('q-number-box').innerText = qIdx + 2;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                finishQuiz();
            }
        }

        // ==========================================
        // YAKUNIY EKRAN (TEGMANG — o'zgarishsiz)
        // ==========================================
        function finishQuiz() {
            clearInterval(timerInterval);
            document.getElementById('timer-box').classList.add('hidden');
            document.getElementById('quiz-wrapper').classList.add('hidden');

            // O'tdi/Yiqildi mantiq
            // Haqiqiy ishlangan savollar sonini backenddan olamiz + bu sessiyada yangi ishlanganlar
            // finishQuiz vaqtida correctCount allaqachon to'liq (eski + yangi)
            let actualTotal = {{ $answeredCount }} + (correctCount - {{ $correctAnsweredCount }})
                            + ({{ $questions->count() }} - {{ $answeredCount }} > 0
                               ? (document.querySelectorAll('.question-step:not(.hidden)').length > 0
                                  ? /* joriy sessiyada ishlagan */ (function(){
                                       let done = 0;
                                       document.querySelectorAll('[id^="feedback-"]').forEach(el => {
                                           if(!el.classList.contains('hidden')) done++;
                                       });
                                       return done;
                                    })()
                                  : 0)
                               : 0);

            // Sodda va ishonchli hisoblash: backend answered + shu sahifada feedback ko'ringan savollar
            let answeredNow = 0;
            document.querySelectorAll('[id^="feedback-"]').forEach(el => {
                if (!el.classList.contains('hidden')) answeredNow++;
            });
            let realTotal = {{ $answeredCount }} + answeredNow;

            let finalTitle = "";
            let titleColor = "";

            if (testType === "random") {
                if (realTotal === 20 && correctCount >= 18) {
                    finalTitle = "Imtihondan o'tdingiz! 🎉";
                    titleColor = "text-green-500";
                } else {
                    finalTitle = "Yiqildingiz! ❌";
                    titleColor = "text-red-500";
                }
            } else {
                finalTitle = "Test Yakunlandi!";
                titleColor = "text-violet-600";
            }

            let finalScreen = document.getElementById('final-screen');
            finalScreen.classList.remove('hidden');
            finalScreen.querySelector('h2').innerText = finalTitle;

            let finalScoreEl = document.getElementById('final-score');
            finalScoreEl.innerText = `${correctCount}/${realTotal}`;
            finalScoreEl.className = `text-6xl font-black mb-6 ${titleColor}`;

            // Natijani bazaga saqlash
            fetch("{{ route('tests.save') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    correct: correctCount,
                    total: realTotal,
                    type: testType,
                    answers: [] // Javoblar allaqachon save_answer orqali saqlangan
                })
            });
        }
    </script>
</body>
</html>