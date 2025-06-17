<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Link -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <h1>Forgot Password</h1>

            <div class="input-box">
                <input type="email" name="email" class="form-controll" placeholder="Email" required>
            </div>

            <button type="submit" class="btn">Kirim Link Reset</button>

            <div class="register-link">
                <p>Sudah ingat password? <a href="/login-page">Login</a></p>
            </div>

            @if (session('status'))
                <p style="color: green; text-align:center;">{{ session('status') }}</p>
            @endif

            @if ($errors->any())
                <ul style="color: red; padding-left: 0; list-style: none; text-align:center;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>
    </div>
</body>
</html>
