@extends('admin.layouts.app')

@section('title', 'BOSH SAHIFA')

@section('content')

    {{--  <!-- Page Header -->
      <div style="margin-bottom:28px;">
          <h1 style="font-size:24px; font-weight:700; color:#1C2434; margin:0 0 4px;">Dashboard</h1>
          <p style="font-size:14px; color:#637381; margin:0;">Biznesingizning umumiy ko'rinishi</p>
      </div>--}}

    <!-- ==================== STATISTICS CARDS ==================== -->
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:24px;">

        <!-- Total Views / Products -->
        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <div
                    style="width:36px; height:36px; background:#FFFFFF; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L22 12L12 22L2 12L12 2Z" fill="black"/>

                        <path d="M12 3.5L20.5 12L12 20.5L3.5 12L12 3.5Z" fill="white"/>

                        <path d="M12 5L19 12L12 19L5 12L12 5Z" fill="#FFD700"/>
                    </svg>
                </div>
            </div>
            <div style="display:flex; align-items:flex-end; justify-content:space-between;">
                <div>
                    <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['categories']['total'] }}</p>
                    <p style="font-size:13px; color:#637381; margin:0;">Jami Variantlar</p>
                </div>
                {{-- <div style="display:flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px;
                 {{ $stats['products']['growth']['is_positive'] ? 'background:#F0FDF4; color:#16A34A;' : 'background:#FEF2F2; color:#DC2626;' }}">
                     <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                          viewBox="0 0 24 24">
                         @if($stats['products']['growth']['is_positive'])
                             <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                         @else
                             <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                         @endif
                     </svg>
                     <span style="font-size:12px; font-weight:600;">{{ $stats['products']['growth']['value'] }}%</span>
                 </div>--}}
            </div>
        </div>

        <!-- Orders -->
        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#F0FDF4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <div
                    style="width:36px; height:36px; background:#FFFFFF; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L21 19H3L12 3Z" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round"
                              stroke-linejoin="round" fill="white"/>

                        <path d="M12 5.5L18.5 17.5H5.5L12 5.5Z" fill="white"/>
                    </svg>
                </div>
            </div>
            <div style="display:flex; align-items:flex-end; justify-content:space-between;">
                <div>
                    <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['questions']['total'] }}</p>
                    <p style="font-size:13px; color:#637381; margin:0;">Jami Test Savollar</p>
                </div>
                {{--  <div style="display:flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px;
                  {{ $stats['orders']['growth']['is_positive'] ? 'background:#F0FDF4; color:#16A34A;' : 'background:#FEF2F2; color:#DC2626;' }}">
                      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                           viewBox="0 0 24 24">
                          @if($stats['orders']['growth']['is_positive'])
                              <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                          @else
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                          @endif
                      </svg>
                      <span style="font-size:12px; font-weight:600;">{{ $stats['orders']['growth']['value'] }}%</span>
                  </div>--}}
            </div>
        </div>
        <!-- Users -->
        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#FDF4FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <div
                    style="width:36px; height:36px; background:#FFFFFF; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
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
            <div style="display:flex; align-items:flex-end; justify-content:space-between;">
                <div>
                    <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['sessions']['total'] }}</p>
                    <p style="font-size:13px; color:#637381; margin:0;">Jami Yechilgan Testlar</p>
                </div>
                {{--<div style="display:flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px;
                {{ $stats['users']['growth']['is_positive'] ? 'background:#F0FDF4; color:#16A34A;' : 'background:#FEF2F2; color:#DC2626;' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                         viewBox="0 0 24 24">
                        @if($stats['users']['growth']['is_positive'])
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        @endif
                    </svg>
                    <span style="font-size:12px; font-weight:600;">{{ $stats['users']['growth']['value'] }}%</span>
                </div>--}}
            </div>
        </div>

        <!-- Users -->
        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div
                style="width:48px; height:48px; background:#FDF4FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <svg width="24" height="24" fill="none" stroke="#9333EA" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div style="display:flex; align-items:flex-end; justify-content:space-between;">
                <div>
                    <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">{{ $stats['users']['total'] }}</p>
                    <p style="font-size:13px; color:#637381; margin:0;">Foydalanuvchilar</p>
                </div>
                {{--<div style="display:flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px;
                {{ $stats['users']['growth']['is_positive'] ? 'background:#F0FDF4; color:#16A34A;' : 'background:#FEF2F2; color:#DC2626;' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                         viewBox="0 0 24 24">
                        @if($stats['users']['growth']['is_positive'])
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        @endif
                    </svg>
                    <span style="font-size:12px; font-weight:600;">{{ $stats['users']['growth']['value'] }}%</span>
                </div>--}}
            </div>
        </div>

        <!-- Revenue -->
        {{-- <div
             style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
             <div
                 style="width:48px; height:48px; background:#FFFBEB; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                 <svg width="24" height="24" fill="none" stroke="#D97706" stroke-width="2" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round"
                           d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                 </svg>
             </div>
             <div style="display:flex; align-items:flex-end; justify-content:space-between;">
                 <div>
                     <p style="font-size:28px; font-weight:700; color:#1C2434; margin:0 0 4px;">
                         ${{ number_format($stats['revenue']['total'], 0) }}</p>
                     <p style="font-size:13px; color:#637381; margin:0;">Jami Daromad</p>
                 </div>
                 <div style="display:flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px;
                 {{ $stats['revenue']['growth']['is_positive'] ? 'background:#F0FDF4; color:#16A34A;' : 'background:#FEF2F2; color:#DC2626;' }}">
                     <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                          viewBox="0 0 24 24">
                         @if($stats['revenue']['growth']['is_positive'])
                             <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                         @else
                             <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                         @endif
                     </svg>
                     <span style="font-size:12px; font-weight:600;">{{ $stats['revenue']['growth']['value'] }}%</span>
                 </div>
             </div>
         </div>--}}

    </div>

    <!-- ==================== CHARTS SECTION ==================== -->
    {{--<div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:24px;">

        <!-- Main Chart -->
        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div>
                    <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Daromad Ko'rinishi</h3>
                    <p style="font-size:12px; color:#637381; margin:0;">Oy bo'yicha daromad statistikasi</p>
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
            <div id="mainChart"></div>

            <!-- Summary -->
            <div
                style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:20px; padding-top:20px; border-top:1px solid #F3F4F6;">
                <div style="text-align:center;">
                    <p style="font-size:20px; font-weight:700; color:#1C2434; margin:0 0 4px;">
                        ${{ number_format($stats['revenue']['this_month'], 0) }}</p>
                    <p style="font-size:12px; color:#637381; margin:0;">Bu oylik daromad</p>
                </div>
                <div style="text-align:center; border-left:1px solid #F3F4F6;">
                    <p style="font-size:20px; font-weight:700; color:#1C2434; margin:0 0 4px;">
                        ${{ number_format($stats['revenue']['total'], 0) }}</p>
                    <p style="font-size:12px; color:#637381; margin:0;">Jami daromad</p>
                </div>
            </div>
        </div>

        <!-- Weekly Profit Chart -->
        <div
            style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6;">
            <div style="margin-bottom:20px;">
                <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0 0 2px;">Haftalik Foyda</h3>
                <p style="font-size:12px; color:#637381; margin:0;">So'nggi 7 kunlik ko'rsatkich</p>
            </div>
            <div id="weeklyChart"></div>

            <!-- Stats -->
            <div style="margin-top:16px; padding-top:16px; border-top:1px solid #F3F4F6;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span style="font-size:12px; color:#637381;">Bu oy yangi buyurtmalar</span>
                    <span
                        style="font-size:13px; font-weight:600; color:#1C2434;">{{ $stats['orders']['this_month'] }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span style="font-size:12px; color:#637381;">Bu oy yangi foydalanuvchilar</span>
                    <span
                        style="font-size:13px; font-weight:600; color:#1C2434;">{{ $stats['users']['this_month'] }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:12px; color:#637381;">Bu oy yangi mahsulotlar</span>
                    <span
                        style="font-size:13px; font-weight:600; color:#1C2434;">{{ $stats['products']['this_month'] }}</span>
                </div>
            </div>
        </div>

    </div>--}}

    <!-- ==================== TABLES SECTION ==================== -->
    <div style="display:grid; grid-template-columns:3fr 2fr; gap:20px;">

        <!-- Recent Orders -->
        {{-- <div
             style="background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6; overflow:hidden;">
             <div
                 style="padding:20px 24px; border-bottom:1px solid #F3F4F6; display:flex; justify-content:space-between; align-items:center;">
                 <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0;">Oxirgi Buyurtmalar</h3>
                 <a href="#" style="font-size:13px; color:#5750F1; text-decoration:none; font-weight:500;">Barchasini
                     ko'rish →</a>
             </div>
             <table style="width:100%; border-collapse:collapse;">
                 <thead>
                 <tr style="background:#F7F9FC;">
                     <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                         Mijoz
                     </th>
                     <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                         Summa
                     </th>
                     <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                         Status
                     </th>
                     <th style="padding:12px 24px; text-align:left; font-size:11px; font-weight:600; color:#8899A8; text-transform:uppercase; letter-spacing:.06em;">
                         Sana
                     </th>
                 </tr>
                 </thead>
                 <tbody>
                 @forelse($recentOrders as $order)
                     <tr style="border-top:1px solid #F3F4F6;">
                         <td style="padding:14px 24px;">
                             <div style="display:flex; align-items:center; gap:10px;">
                                 <div
                                     style="width:34px; height:34px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                     <span
                                         style="font-size:12px; font-weight:700; color:#5750F1;">{{ strtoupper(substr($order->user->name ?? 'N', 0, 1)) }}</span>
                                 </div>
                                 <div>
                                     <p style="font-size:13px; font-weight:600; color:#1C2434; margin:0;">{{ $order->user->name ?? 'Noma\'lum' }}</p>
                                 </div>
                             </div>
                         </td>
                         <td style="padding:14px 16px; font-size:13px; font-weight:600; color:#1C2434;">
                             ${{ number_format($order->total_amount, 2) }}</td>
                         <td style="padding:14px 16px;">
                             <span style="padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;
                                 @if($order->status === 'delivered') background:#F0FDF4; @elseif($order->status === 'pending') background:#FFFBEB; @elseif($order->status === 'processing') background:#EEF2FF; color:#5750F1;
                                 @elseif($order->status === 'cancelled') background:#FEF2F2; @else background:#F3F4F6;@endif">
                                 {{ ucfirst($order->status) }}
                             </span>
                         </td>
                         <td style="padding:14px 24px; font-size:12px; color:#8899A8;">{{ $order->created_at->format('d M, Y') }}</td>
                     </tr>
                 @empty
                     <tr>
                         <td colspan="4" style="padding:32px; text-align:center; color:#8899A8; font-size:13px;">
                             Buyurtmalar yo'q
                         </td>
                     </tr>
                 @endforelse
                 </tbody>
             </table>
         </div>--}}

        <!-- Recent Users -->
        {{-- <div
             style="background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F3F4F6; overflow:hidden;">
             <div
                 style="padding:20px 24px; border-bottom:1px solid #F3F4F6; display:flex; justify-content:space-between; align-items:center;">
                 <h3 style="font-size:16px; font-weight:700; color:#1C2434; margin:0;">Yangi Foydalanuvchilar</h3>
                 <a href="#" style="font-size:13px; color:#5750F1; text-decoration:none; font-weight:500;">Barchasini
                     ko'rish →</a>
             </div>
             <ul style="list-style:none; margin:0; padding:0;">
                 @forelse($recentUsers as $user)
                     <li style="display:flex; align-items:center; gap:12px; padding:14px 24px; border-top:1px solid #F3F4F6;">
                         <div
                             style="width:40px; height:40px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                             <span
                                 style="font-size:15px; font-weight:700; color:#5750F1;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                         </div>
                         <div style="flex:1; min-width:0;">
                             <p style="font-size:13px; font-weight:600; color:#1C2434; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $user->name }}</p>
                             <p style="font-size:11px; color:#8899A8; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $user->email }}</p>
                         </div>
                         <span
                             style="font-size:11px; color:#8899A8; white-space:nowrap;">{{ $user->created_at->format('d M') }}</span>
                     </li>
                 @empty
                     <li style="padding:32px; text-align:center; color:#8899A8; font-size:13px;">Foydalanuvchilar yo'q
                     </li>
                 @endforelse
             </ul>
         </div>--}}

    </div>

@endsection

{{--@section('scripts')
    <script>
        const dailyStats = @json($dailyStats);
        const monthlyStats = @json($monthlyStats);
        const yearlyStats = @json($yearlyStats);

        let mainChart = null;

        function renderMainChart(labels, data) {
            if (mainChart) mainChart.destroy();

            mainChart = new ApexCharts(document.querySelector('#mainChart'), {
                series: [{name: 'Daromad ($)', data}],
                chart: {type: 'area', height: 220, toolbar: {show: false}, sparkline: {enabled: false}},
                colors: ['#5750F1'],
                fill: {type: 'gradient', gradient: {shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02}},
                stroke: {curve: 'smooth', width: 2.5},
                dataLabels: {enabled: false},
                xaxis: {
                    categories: labels,
                    axisBorder: {show: false},
                    axisTicks: {show: false},
                    labels: {style: {colors: '#8899A8', fontSize: '11px'}}
                },
                yaxis: {labels: {formatter: v => '$' + v.toFixed(0), style: {colors: '#8899A8', fontSize: '11px'}}},
                grid: {borderColor: '#F3F4F6', strokeDashArray: 3},
                tooltip: {y: {formatter: v => '$' + v.toFixed(2)}}
            });
            mainChart.render();
        }

        function updateChart(type) {
            const btns = ['daily', 'monthly', 'yearly'];
            btns.forEach(b => {
                const el = document.getElementById('btn-' + b);
                if (b === type) {
                    el.style.background = '#5750F1';
                    el.style.color = '#fff';
                    el.style.border = 'none';
                } else {
                    el.style.background = '#fff';
                    el.style.color = '#637381';
                    el.style.border = '1px solid #E8E8E8';
                }
            });
            const map = {daily: dailyStats, monthly: monthlyStats, yearly: yearlyStats};
            renderMainChart(map[type].labels, map[type].data);
        }

        // Weekly bar chart
        new ApexCharts(document.querySelector('#weeklyChart'), {
            series: [{name: 'Daromad', data: dailyStats.data}],
            chart: {type: 'bar', height: 200, toolbar: {show: false}},
            colors: ['#5750F1'],
            plotOptions: {bar: {borderRadius: 4, columnWidth: '55%'}},
            dataLabels: {enabled: false},
            xaxis: {
                categories: dailyStats.labels,
                axisBorder: {show: false},
                axisTicks: {show: false},
                labels: {style: {colors: '#8899A8', fontSize: '10px'}}
            },
            yaxis: {labels: {formatter: v => '$' + v.toFixed(0), style: {colors: '#8899A8', fontSize: '10px'}}},
            grid: {borderColor: '#F3F4F6', strokeDashArray: 3},
            tooltip: {y: {formatter: v => '$' + v.toFixed(2)}}
        }).render();

        // Init
        renderMainChart(dailyStats.labels, dailyStats.data);
    </script>
@endsection--}}
