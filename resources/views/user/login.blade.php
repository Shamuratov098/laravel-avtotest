<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tizimga kirish</title>
    <link rel="stylesheet" href="{{ asset('css/user/login.css') }}">
</head>
<body>

    <div class="login-container">
        
        <div class="login-header">
            <h2>Tizimga kirish</h2>
            <p>Hisobingizga kirish uchun ma'lumotlaringizni kiriting</p>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <div class="form-group">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email manzil" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Parol" required>
                <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Eslab qolish
                </label>
                <a href="#" class="forgot-link">Parolni unutdingizmi?</a>
            </div>

            <button type="submit" class="btn-submit">Kirish</button>
        </form>

        <div class="register-link">
            Hisobingiz yo'qmi? <a href="{{ route('register') }}">Ro'yxatdan o'tish</a>
        </div>

    </div>

</body>
</html>