@extends('admin.layouts.app')

@section('title', 'BOSH SAHIFA')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @php
        $cards = [
            [
                'key' => 'categories',
                'value' => $stats['categories']['total'],
                'label' => 'Jami Variantlar',
                'stripe' => 'card-stripe-indigo',
                'icon_color' => '#5750F1',
                'icon_bg' => '#EEF2FF',
                'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                'secondary' => null,
            ],
            [
                'key' => 'questions',
                'value' => $stats['questions']['total'],
                'label' => 'Jami Test Savollar',
                'stripe' => 'card-stripe-rose',
                'icon_color' => '#EC4899',
                'icon_bg' => '#FDF2F8',
                'icon' => 'M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.5M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z',
                'secondary' => null,
            ],
            [
                'key' => 'sessions',
                'value' => $stats['sessions']['total'],
                'label' => 'Jami Yechilgan Testlar',
                'stripe' => 'card-stripe-blue',
                'icon_color' => '#3B82F6',
                'icon_bg' => '#EFF6FF',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'secondary' => ['label' => 'bugun', 'value' => $stats['sessions']['today']],
            ],
            [
                'key' => 'users',
                'value' => $stats['users']['total'],
                'label' => 'Foydalanuvchilar',
                'stripe' => 'card-stripe-emerald',
                'icon_color' => '#10B981',
                'icon_bg' => '#ECFDF5',
                'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z',
                'secondary' => ['label' => 'bu hafta yangi', 'value' => $stats['users']['new_this_week']],
            ],
        ];

        $trendIcon = fn($dir) => match ($dir) {
            'up' => '↑',
            'down' => '↓',
            default => '—',
        };
        $trendClass = fn($dir) => match ($dir) {
            'up' => 'trend-up',
            'down' => 'trend-down',
            default => 'trend-flat',
        };

        $avatarPalette = [
            ['bg' => '#EEF2FF', 'fg' => '#5750F1'],
            ['bg' => '#FDF2F8', 'fg' => '#EC4899'],
            ['bg' => '#EFF6FF', 'fg' => '#3B82F6'],
            ['bg' => '#ECFDF5', 'fg' => '#10B981'],
            ['bg' => '#FEF3C7', 'fg' => '#D97706'],
        ];
        $avatarFor = function (string $name) use ($avatarPalette) {
            $idx = abs(crc32($name)) % count($avatarPalette);
            return $avatarPalette[$idx];
        };
    @endphp

    {{-- ============== STAT CARDS ============== --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:24px;">
        @foreach($cards as $card)
            @php $trend = $trends[$card['key']]; @endphp
            <div class="stat-card card-stripe {{ $card['stripe'] }}"
                 style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">

                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:18px;">
                    <div style="width:44px; height:44px; background:{{ $card['icon_bg'] }}; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                        <svg width="22" height="22" fill="none" stroke="{{ $card['icon_color'] }}" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="trend-pill {{ $trendClass($trend['direction']) }}">
                        {{ $trendIcon($trend['direction']) }} {{ $trend['percent'] }}%
                    </span>
                </div>

                <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px; line-height:1.1;">
                    {{ number_format($card['value']) }}
                </p>
                <p style="font-size:13px; color:#637381; margin:0;">{{ $card['label'] }}</p>

                @if($card['secondary'])
                    <div style="margin-top:14px; padding-top:12px; border-top:1px solid #F3F4F6; display:flex; align-items:center; gap:6px;">
                        <span style="font-size:13px; font-weight:700; color:#1C2434;">+{{ number_format($card['secondary']['value']) }}</span>
                        <span style="font-size:12px; color:#8899A8;">{{ $card['secondary']['label'] }}</span>
                    </div>
                @else
                    <div style="margin-top:14px; padding-top:12px; border-top:1px solid #F3F4F6;">
                        <span style="font-size:12px; color:#8899A8;">so'nggi 7 kun bo'yicha</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- ============== MAIN CHART ============== --}}
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.08); margin-bottom:24px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Test Bajarishlar</h3>
                <p style="font-size:12px; color:#637381; margin:0;" id="chart-subtitle">Oxirgi 30 kun bo'yicha statistika</p>
            </div>
            <div style="display:flex; gap:8px;">
                <button onclick="updateChart('daily')" id="btn-daily"
                        style="padding:6px 14px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:none; background:#5750F1; color:#fff; transition:all .2s;">
                    Kunlik
                </button>
                <button onclick="updateChart('monthly')" id="btn-monthly"
                        style="padding:6px 14px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:1px solid #E8E8E8; background:#fff; color:#637381; transition:all .2s;">
                    Oylik
                </button>
                <button onclick="updateChart('yearly')" id="btn-yearly"
                        style="padding:6px 14px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:1px solid #E8E8E8; background:#fff; color:#637381; transition:all .2s;">
                    Yillik
                </button>
            </div>
        </div>
        <canvas id="dailyChart" height="100"></canvas>
    </div>

    {{-- ============== TOP CATEGORIES + PASS RATE ============== --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:24px;">

        {{-- Top Categories --}}
        <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div style="margin-bottom:18px;">
                <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Top Kategoriyalar</h3>
                <p style="font-size:12px; color:#637381; margin:0;">Eng ko'p yechilgan variantlar</p>
            </div>

            @if(count($topCategories) === 0)
                <div style="padding:30px 0; text-align:center; color:#8899A8; font-size:13px;">Ma'lumot yo'q</div>
            @else
                <div style="display:flex; flex-direction:column; gap:16px;">
                    @foreach($topCategories as $i => $cat)
                        <div>
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                                <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                                    <span style="display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:6px; background:#F3F4F6; color:#637381; font-size:12px; font-weight:700;">{{ $i + 1 }}</span>
                                    <span style="font-size:14px; font-weight:600; color:#1C2434; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $cat['name'] }}</span>
                                </div>
                                <span style="font-size:13px; color:#637381; font-weight:500; white-space:nowrap;">{{ number_format($cat['count']) }} ta test</span>
                            </div>
                            <div class="cat-progress-track">
                                <div class="cat-progress-fill" style="width: {{ $cat['percent'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Pass Rate --}}
        <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div style="margin-bottom:18px;">
                <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Testdan o'tish ko'rsatgichlari</h3>
                <p style="font-size:12px; color:#637381; margin:0;">So'nggi 30 kun</p>
            </div>

            @if($passRate['total'] === 0)
                <div style="padding:60px 0; text-align:center; color:#8899A8; font-size:13px;">Ma'lumot yo'q</div>
            @else
                <div style="position:relative; width:100%; max-width:200px; margin:0 auto;">
                    <canvas id="passRateChart"></canvas>
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; pointer-events:none;">
                        <div style="font-size:28px; font-weight:700; color:#1C2434; line-height:1;">{{ $passRate['percent'] }}%</div>
                        <div style="font-size:11px; color:#8899A8; margin-top:2px;">o'tgan</div>
                    </div>
                </div>

                <div style="margin-top:18px; display:flex; flex-direction:column; gap:8px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; font-size:13px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:10px; height:10px; border-radius:50%; background:#10B981; display:inline-block;"></span>
                            <span style="color:#637381;">O'tgan</span>
                        </div>
                        <span style="color:#1C2434; font-weight:600;">{{ number_format($passRate['passed']) }}</span>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; font-size:13px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:10px; height:10px; border-radius:50%; background:#EF4444; display:inline-block;"></span>
                            <span style="color:#637381;">Yiqilgan</span>
                        </div>
                        <span style="color:#1C2434; font-weight:600;">{{ number_format($passRate['failed']) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ============== RECENT SESSIONS FEED ============== --}}
    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
        <div style="margin-bottom:18px;">
            <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Oxirgi yechilgan testlar</h3>
            <p style="font-size:12px; color:#637381; margin:0;">So'nggi {{ count($recentSessions) }} ta sessiya</p>
        </div>

        @if(count($recentSessions) === 0)
            <div style="padding:30px 0; text-align:center; color:#8899A8; font-size:13px;">Hali yechilgan testlar yo'q</div>
        @else
            <div>
                @foreach($recentSessions as $s)
                    @php
                        $av = $avatarFor($s['user_name']);
                        $initial = mb_strtoupper(mb_substr($s['user_name'], 0, 1));
                    @endphp
                    <div class="session-row" style="display:flex; align-items:center; gap:14px; padding:12px 8px; border-radius:8px;">
                        <div style="width:40px; height:40px; min-width:40px; border-radius:50%; background:{{ $av['bg'] }}; display:flex; align-items:center; justify-content:center;">
                            <span style="font-size:15px; font-weight:700; color:{{ $av['fg'] }};">{{ $initial }}</span>
                        </div>

                        <div style="flex:1; min-width:0;">
                            <div style="font-size:14px; font-weight:600; color:#1C2434; margin-bottom:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                {{ $s['user_name'] }}
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:#8899A8;">
                                @if($s['is_random'])
                                    <span style="display:inline-flex; align-items:center; padding:2px 8px; border-radius:999px; background:#F3F4F6; color:#637381; font-weight:600; font-size:11px;">Tasodifiy</span>
                                @else
                                    <span style="color:#637381; font-weight:500;">{{ $s['category_label'] }}</span>
                                @endif
                                <span style="color:#D1D5DB;">·</span>
                                <span>{{ $s['time_ago'] }}</span>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:14px; font-weight:700; color:#1C2434;">{{ $s['correct'] }}/{{ $s['total'] }}</span>
                            <span class="pass-badge {{ $s['passed'] ? 'pass-badge-yes' : 'pass-badge-no' }}">
                                {{ $s['passed'] ? '✓ O\'tdi' : '✗ Yiqildi' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ============== SCRIPTS ============== --}}
    <script>
        (function () {
            const datasets = {
                daily: {
                    data: @json($dailyTests),
                    subtitle: "Oxirgi 30 kun bo'yicha statistika",
                    format: date => {
                        const d = new Date(date);
                        const months = ['Yan', 'Feb', 'Mar', 'Apr', 'May', 'Iyn', 'Iyl', 'Avg', 'Sen', 'Okt', 'Noy', 'Dek'];
                        return months[d.getMonth()] + ' ' + d.getDate();
                    },
                },
                monthly: {
                    data: @json($monthlyTests),
                    subtitle: "Oxirgi 12 oy bo'yicha statistika",
                    format: month => {
                        const [y, m] = month.split('-');
                        const months = ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'];
                        return months[parseInt(m) - 1] + ' ' + y;
                    },
                },
                yearly: {
                    data: @json($yearlyTests),
                    subtitle: "Oxirgi 5 yil bo'yicha statistika",
                    format: year => year + '-yil',
                },
            };

            const lineCanvas = document.getElementById('dailyChart');
            const lineCtx = lineCanvas.getContext('2d');
            const gradient = lineCtx.createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(87,80,241,0.28)');
            gradient.addColorStop(1, 'rgba(87,80,241,0)');

            const chart = new Chart(lineCanvas, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Testlar soni',
                        data: [],
                        borderColor: '#5750F1',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#5750F1',
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: '#5750F1',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 5,
                    interaction: {mode: 'index', intersect: false},
                    plugins: {
                        legend: {display: false},
                        tooltip: {
                            backgroundColor: 'rgba(28, 36, 52, 0.92)',
                            titleColor: '#fff',
                            bodyColor: '#E5E7EB',
                            titleFont: {size: 12, weight: '600'},
                            bodyFont: {size: 13, weight: '600'},
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: ctx => ` ${ctx.raw} ta test`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {precision: 0, color: '#8899A8', font: {size: 11}},
                            grid: {color: 'rgba(0,0,0,0.04)', drawBorder: false},
                            border: {display: false},
                        },
                        x: {
                            ticks: {maxTicksLimit: 10, color: '#8899A8', font: {size: 11}},
                            grid: {display: false},
                            border: {display: false},
                        }
                    }
                }
            });

            window.updateChart = function (type) {
                const set = datasets[type];
                const raw = set.data;

                chart.data.labels = Object.keys(raw).map(set.format);
                chart.data.datasets[0].data = Object.values(raw);
                chart.update();

                document.getElementById('chart-subtitle').textContent = set.subtitle;

                ['daily', 'monthly', 'yearly'].forEach(t => {
                    const btn = document.getElementById(`btn-${t}`);
                    if (t === type) {
                        btn.style.background = '#5750F1';
                        btn.style.color = '#fff';
                        btn.style.border = 'none';
                    } else {
                        btn.style.background = '#fff';
                        btn.style.color = '#637381';
                        btn.style.border = '1px solid #E8E8E8';
                    }
                });
            };

            updateChart('daily');

            const passRateEl = document.getElementById('passRateChart');
            if (passRateEl) {
                new Chart(passRateEl, {
                    type: 'doughnut',
                    data: {
                        labels: ["O'tgan", 'Yiqilgan'],
                        datasets: [{
                            data: [{{ $passRate['passed'] }}, {{ $passRate['failed'] }}],
                            backgroundColor: ['#10B981', '#EF4444'],
                            borderWidth: 0,
                            hoverOffset: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '72%',
                        plugins: {
                            legend: {display: false},
                            tooltip: {
                                backgroundColor: 'rgba(28, 36, 52, 0.92)',
                                titleColor: '#fff',
                                bodyColor: '#E5E7EB',
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${ctx.raw} ta`
                                }
                            }
                        }
                    }
                });
            }
        })();
    </script>

@endsection
