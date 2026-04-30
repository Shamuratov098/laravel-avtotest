<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 p-6 md:p-12">
    <div class="max-w-5xl mx-auto space-y-8">
        
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight">Statistikam</h1>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-violet-600 transition">
                <i class="fas fa-arrow-left mr-1"></i> Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Umumiy urinishlar</p>
                <h2 class="text-4xl font-black text-slate-800">{{ $totalAttempts }} ta</h2>
            </div>
            <div class="bg-violet-600 p-6 rounded-[32px] shadow-lg shadow-violet-200 text-white">
                <p class="text-xs font-black text-violet-200 uppercase tracking-widest mb-2">O'rtacha aniqlik</p>
                <h2 class="text-4xl font-black">{{ $accuracy }}%</h2>
            </div>
            <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jami to'g'ri javoblar</p>
                <h2 class="text-4xl font-black text-slate-800">{{ $totalCorrect }} ta</h2>
            </div>
        </div>

        <div class="bg-white rounded-[40px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50">
                <h3 class="font-bold text-slate-800 uppercase text-sm tracking-widest">Oxirgi urinishlar tarixi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase">
                        <tr>
                            <th class="px-6 py-4">Sana</th>
                            <th class="px-6 py-4">Test Turi</th>
                            <th class="px-6 py-4">Natija</th>
                            <th class="px-6 py-4">Foiz</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($sessions as $session)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-500">{{ $session->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-6 py-4">
                            @if($session->category_id && $session->category)
                                <span class="text-violet-600 font-bold">
                                    <i class="fas fa-folder mr-1"></i> {{ $session->category->name }}
                                </div>
                            @else
                                <span class="text-slate-500 font-medium">
                                    <i class="fas fa-dice mr-1"></i> Tasodifiy (Random)
                                </span>
                            @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-violet-100 text-violet-700 rounded-full font-bold text-xs">
                                    {{ $session->correct_count }} / {{ $session->total_questions }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-slate-800">
                                {{ round(($session->correct_count / $session->total_questions) * 100) }}%
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold">Hali test topshirilmagan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-slate-50 border-t border-slate-100">
             {{ $sessions->links() }}
            </div>
        </div>
    </div>
</body>
</html>