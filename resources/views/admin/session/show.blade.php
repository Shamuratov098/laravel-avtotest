@extends('admin.layouts.app')

@section('title', 'SESSIYA #' . $session->id)

@section('content')

    @php
        use App\TestSessionStatus;
        use App\TestSessionType;

        $isCompleted = $session->status === TestSessionStatus::COMPLETED;
        $isRandom = $session->type === TestSessionType::RANDOM;
        $total = max((int) $session->total_questions, 1);
        $correct = (int) $session->correct_count;
        $percent = $isCompleted ? (int) round(($correct / $total) * 100) : null;
        $passed = $isCompleted && $percent >= 90;
    @endphp

    <!-- Top actions: back + delete -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <a href="{{ route('admin.sessions.index') }}"
           style="display:inline-flex; align-items:center; gap:8px; padding:9px 16px; background:#fff; color:#637381; border:1px solid #E8E8E8; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Ro'yxatga qaytish
        </a>

        <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST"
              onsubmit="return confirm('Rostdan ham ushbu sessiyani o\'chirmoqchimisiz?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    style="display:inline-flex; align-items:center; gap:8px; padding:9px 16px; background:#FEF2F2; color:#DC2626; border:1px solid #FEE2E2; border-radius:8px; cursor:pointer; font-size:13px; font-weight:600;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                O'chirish
            </button>
        </form>
    </div>

    <!-- Summary card -->
    <div style="background:#fff; border-radius:12px; border:1px solid #F3F4F6; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:24px; margin-bottom:24px;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:18px;">

            <!-- User -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Foydalanuvchi</p>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:36px; height:36px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:14px; font-weight:700; color:#5750F1;">
                            {{ strtoupper(mb_substr($session->user->name ?? '?', 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p style="font-size:14px; font-weight:600; color:#1C2434; margin:0;">{{ $session->user->name ?? '—' }}</p>
                        <p style="font-size:12px; color:#8899A8; margin:0;">{{ $session->user->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Type / Category -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Test turi</p>
                @if($isRandom)
                    <span style="display:inline-block; padding:5px 12px; background:#FEF3C7; color:#92400E; border-radius:6px; font-size:12px; font-weight:600;">Tasodifiy</span>
                @else
                    <span style="display:inline-block; padding:5px 12px; background:#EEF2FF; color:#5750F1; border-radius:6px; font-size:12px; font-weight:600;">{{ $session->category->name ?? 'Kategoriya' }}</span>
                @endif
            </div>

            <!-- Status -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Status</p>
                @if($isCompleted)
                    <span style="display:inline-block; padding:5px 12px; background:#F0FDF4; color:#15803D; border-radius:6px; font-size:12px; font-weight:600;">Tugatilgan</span>
                @else
                    <span style="display:inline-block; padding:5px 12px; background:#FEF3C7; color:#92400E; border-radius:6px; font-size:12px; font-weight:600;">Jarayonda</span>
                @endif
            </div>

            <!-- Result -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Natija</p>
                @if($isCompleted)
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:18px; font-weight:700; color:#1C2434;">{{ $correct }}/{{ $total }}</span>
                        <span style="font-size:12px; color:#637381;">({{ $percent }}%)</span>
                        @if($passed)
                            <span style="display:inline-block; padding:3px 9px; background:#F0FDF4; color:#15803D; border-radius:5px; font-size:10px; font-weight:700;">O'TDI</span>
                        @else
                            <span style="display:inline-block; padding:3px 9px; background:#FEF2F2; color:#DC2626; border-radius:5px; font-size:10px; font-weight:700;">O'TMADI</span>
                        @endif
                    </div>
                @else
                    <span style="font-size:13px; color:#8899A8;">—</span>
                @endif
            </div>

            <!-- Duration -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Davomiylik</p>
                <p style="font-size:14px; font-weight:600; color:#1C2434; margin:0;">{{ $session->formattedDuration() ?? '—' }}</p>
            </div>

            <!-- Started -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Boshlangan</p>
                <p style="font-size:13px; color:#637381; margin:0;">{{ $session->started_at->format('d M, Y H:i') }}</p>
            </div>

            <!-- Completed -->
            <div>
                <p style="font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em; margin:0 0 6px;">Tugatilgan</p>
                <p style="font-size:13px; color:#637381; margin:0;">{{ $session->completed_at?->format('d M, Y H:i') ?? '—' }}</p>
            </div>
        </div>
    </div>

    <!-- Per-question breakdown -->
    <h3 style="font-size:15px; font-weight:700; color:#1C2434; margin:0 0 14px;">
        Savol bo'yicha javoblar
        <span style="font-size:13px; font-weight:500; color:#8899A8;">({{ $session->results->count() }})</span>
    </h3>

    @forelse($session->results as $idx => $result)
        @php
            $question = $result->question;
            $chosen = (int) ($result->chosen_answer ?? 0);
            $isCorrect = (bool) $result->is_correct;
            $correctOption = (int) ($question->correct_answer ?? 0);
        @endphp

        <div style="background:#fff; border-radius:12px; border:1px solid {{ $isCorrect ? '#D1FAE5' : '#FECACA' }}; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:20px; margin-bottom:14px;">

            <!-- Question header -->
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:14px; margin-bottom:14px; padding-bottom:14px; border-bottom:1px solid #F3F4F6;">
                <div style="display:flex; gap:12px; flex:1;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:32px; background:#EEF2FF; border-radius:8px; font-size:13px; font-weight:700; color:#5750F1;">
                        {{ $idx + 1 }}
                    </span>
                    <div style="flex:1;">
                        <p style="font-size:14px; font-weight:600; color:#1C2434; margin:0 0 6px; line-height:1.5;">
                            {{ $question?->question_text ?? '— savol topilmadi —' }}
                        </p>
                        @if($question?->category)
                            <span style="font-size:11px; color:#8899A8;">{{ $question->category->name }}</span>
                        @endif
                    </div>
                </div>
                @if($isCorrect)
                    <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 11px; background:#F0FDF4; color:#15803D; border-radius:6px; font-size:11px; font-weight:700; white-space:nowrap;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        TO'G'RI
                    </span>
                @else
                    <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 11px; background:#FEF2F2; color:#DC2626; border-radius:6px; font-size:11px; font-weight:700; white-space:nowrap;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        XATO
                    </span>
                @endif
            </div>

            <!-- Image -->
            @if($question?->image_src)
                <div style="margin-bottom:14px;">
                    <img src="{{ $question->image_src }}" alt="Savol rasmi"
                         style="max-width:320px; max-height:200px; border-radius:8px; border:1px solid #E8EEF3; object-fit:contain;">
                </div>
            @endif

            <!-- Answer options -->
            @if($question)
                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($question->answers->sortBy('option_number') as $answer)
                        @php
                            $isThisCorrect = (int) $answer->option_number === $correctOption;
                            $isThisChosen = (int) $answer->option_number === $chosen;
                            $bg = '#fff';
                            $border = '#E8EEF3';
                            $textColor = '#1C2434';
                            if ($isThisCorrect) {
                                $bg = '#F0FDF4';
                                $border = '#86EFAC';
                            } elseif ($isThisChosen && !$isThisCorrect) {
                                $bg = '#FEF2F2';
                                $border = '#FCA5A5';
                            }
                        @endphp
                        <div style="display:flex; align-items:center; gap:12px; padding:10px 14px; background:{{ $bg }}; border:1.5px solid {{ $border }}; border-radius:8px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#fff; border:1px solid #E8EEF3; border-radius:6px; font-size:12px; font-weight:700; color:#5750F1;">
                                {{ chr(64 + (int) $answer->option_number) }}
                            </span>
                            <span style="flex:1; font-size:13px; color:{{ $textColor }};">{{ $answer->answer_text }}</span>
                            <div style="display:flex; align-items:center; gap:6px;">
                                @if($isThisChosen)
                                    <span style="font-size:10px; font-weight:700; padding:3px 8px; background:#EEF2FF; color:#5750F1; border-radius:4px;">TANLAGAN</span>
                                @endif
                                @if($isThisCorrect)
                                    <span style="font-size:10px; font-weight:700; padding:3px 8px; background:#DCFCE7; color:#15803D; border-radius:4px;">TO'G'RI</span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if($chosen === 0)
                        <div style="padding:10px 14px; background:#F7F9FC; border:1.5px dashed #E8EEF3; border-radius:8px; font-size:12px; color:#8899A8;">
                            Foydalanuvchi javob bermagan
                        </div>
                    @endif
                </div>

                <!-- Explanation -->
                @if($question->explanation)
                    <div style="margin-top:14px; padding:12px 14px; background:#F7F9FC; border-left:3px solid #5750F1; border-radius:0 8px 8px 0;">
                        <p style="font-size:11px; font-weight:700; color:#5750F1; text-transform:uppercase; letter-spacing:.06em; margin:0 0 4px;">Izoh</p>
                        <p style="font-size:13px; color:#1C2434; margin:0; line-height:1.6;">{{ $question->explanation }}</p>
                    </div>
                @endif
            @endif
        </div>
    @empty
        <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; color:#8899A8; font-size:14px;">
            Hozircha bu sessiyada javoblar yo'q.
        </div>
    @endforelse

@endsection