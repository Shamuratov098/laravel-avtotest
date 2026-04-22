@extends('admin.layouts.app')

@section('title', 'BOSH SAHIFA')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:24px;">

        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <div
                    style="width:36px; height:36px; background:#FFFFFF; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L22 12L12 22L2 12L12 2Z" fill="black"/>
                        <path d="M12 3.5L20.5 12L12 20.5L3.5 12L12 3.5Z" fill="white"/>
                        <path d="M12 5L19 12L12 19L5 12L12 5Z" fill="#FFD700"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['categories']['total'] }}</p>
            <p style="font-size:13px; color:#637381; margin:0;">Jami Variantlar</p>
        </div>

        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#F0FDF4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <div
                    style="width:36px; height:36px; background:#FFFFFF; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L21 19H3L12 3Z" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round"
                              stroke-linejoin="round" fill="white"/>
                        <path d="M12 5.5L18.5 17.5H5.5L12 5.5Z" fill="white"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['questions']['total'] }}</p>
            <p style="font-size:13px; color:#637381; margin:0;">Jami Test Savollar</p>
        </div>

        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#FDF4FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <div
                    style="width:36px; height:36px; background:#FFFFFF; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="3" fill="#1D4ED8"/>
                        <path d="M7 20L9 4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M17 20L15 4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <line x1="12" y1="18" x2="12" y2="15" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="12" y1="11" x2="12" y2="8" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M4 11H20" stroke="white" stroke-width="2.5" stroke-linecap="butt"/>
                        <path d="M4 13.5H20" stroke="white" stroke-width="1" stroke-linecap="butt" opacity="0.6"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['sessions']['total'] }}</p>
            <p style="font-size:13px; color:#637381; margin:0;">Jami Yechilgan Testlar</p>
        </div>

        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#FDF4FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <svg width="24" height="24" fill="none" stroke="#9333EA" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['users']['total'] }}</p>
            <p style="font-size:13px; color:#637381; margin:0;">Foydalanuvchilar</p>
        </div>

    </div>

    <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.08);">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Test Bajarishlar</h3>
                <p style="font-size:12px; color:#637381; margin:0;" id="chart-subtitle">Oxirgi 30 kun bo'yicha
                    statistika</p>
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

            const chart = new Chart(document.getElementById('dailyChart'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Testlar soni',
                        data: [],
                        borderColor: '#5750F1',
                        backgroundColor: 'rgba(87,80,241,0.08)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 5,
                    plugins: {
                        legend: {display: false},
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.raw} ta test`
                            }
                        }
                    },
                    scales: {
                        y: {beginAtZero: true, ticks: {precision: 0}},
                        x: {ticks: {maxTicksLimit: 10}}
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
        })();
    </script>

@endsection
