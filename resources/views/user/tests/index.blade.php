<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Turini Tanlang | Avtotest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-4xl w-full">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-gray-800 mb-2">Qanday usulda test ishlaysiz?</h1>
            <p class="text-gray-500">O'zingizga qulay formatni tanlang</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <a href="{{ route('tests.categories') }}" class="group bg-white p-10 rounded-[40px] shadow-sm border-2 border-transparent hover:border-violet-500 hover:shadow-2xl transition-all duration-300 text-center">
                <div class="w-24 h-24 bg-violet-100 text-violet-600 rounded-3xl flex items-center justify-center text-4xl mx-auto mb-6 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Variantlar bo'yicha</h3>
                <p class="text-gray-500 mb-8 text-sm leading-relaxed">
                    111 ta mavzulashtirilgan bo'lim. Har birida bazadagi savollar ketma-ket 10 tadan chiqadi.
                </p>
                <span class="inline-block bg-violet-100 text-violet-700 font-bold py-3 px-10 rounded-2xl group-hover:bg-violet-700 group-hover:text-white transition">Kirish</span>
            </a>

            <a href="{{ route('tests.random') }}" class="group bg-white p-10 rounded-[40px] shadow-sm border-2 border-transparent hover:border-blue-500 hover:shadow-2xl transition-all duration-300 text-center">
                <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-3xl flex items-center justify-center text-4xl mx-auto mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-shuffle"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Tasodifiy (Random)</h3>
                <p class="text-gray-500 mb-8 text-sm leading-relaxed">
                    Barcha 1110 ta savol ichidan 10 ta tasodifiy savol. Haqiqiy imtihon muhiti siz bilan!
                </p>
                <span class="inline-block bg-blue-100 text-blue-700 font-bold py-3 px-10 rounded-2xl group-hover:bg-blue-700 group-hover:text-white transition">Boshlash</span>
            </a>

        </div>

        <div class="text-center mt-12">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-800 font-medium transition flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Boshqaruv paneliga qaytish
            </a>
        </div>
    </div>

</body>
</html>