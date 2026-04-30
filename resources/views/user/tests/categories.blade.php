<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variantlar | Avtotest</title>
    <link rel="stylesheet" href="{{ asset('css/user/categories.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background-color: #f9fafb;">

    <div class="categories-container">
        
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>O'quv variantlari</h1>
                <p style="color: #6b7280; font-size: 14px;">Barcha savollar bo'limlar bo'yicha ajratilgan</p>
            </div>
            <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #7c3aed; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Profilga qaytish
            </a>
        </div>

        <div class="variant-grid">
            @foreach($categories as $index => $cat)
                <a href="{{ route('tests.category', $cat->id) }}" class="variant-card">
                    <div class="variant-number">
                        {{ $index + 1 }}
                    </div>
                    <div class="variant-name">
                        {{ $cat->name }}
                    </div>
                    <div class="question-count">
                        <i class="far fa-file-alt"></i> {{ $cat->questions_count ?? 10 }} ta savol
                    </div>
                </a>
            @endforeach
        </div>

    </div>

</body>
</html>