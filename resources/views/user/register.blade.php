<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ro'yxatdan o'tish</title>
    <link rel="stylesheet" href="{{ asset('css/user/register.css') }}">
</head>
<body>

    <div class="auth-container">
        
        <div class="auth-header">
            <h2>Ro'yxatdan o'tish</h2>
            <p>Yangi hisob yaratish uchun ma'lumotlarni to'ldiring</p>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Ismingiz (F.I.SH)</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Saidjon" required>
            </div>

            <div class="form-group">
                <label class="form-label">Telefon raqam</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+998999999999" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email manzil</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@gmail.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">Parol</label>
                <input type="password" name="password" class="form-control" placeholder="Yangi parol o'ylab toping" required>
            </div>

            <div class="form-group">
                <label class="form-label">Parolni tasdiqlang</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Parolni qayta kiriting" required>
            </div>

            <button type="submit" class="btn-submit">Ro'yxatdan o'tish</button>
        </form>

        <div class="login-link">
            Allaqachon hisobingiz bormi? <a href="{{ route('login') }}">Tizimga kirish</a>
        </div>

    </div>

</body>
</html>