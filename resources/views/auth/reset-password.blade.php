<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <!-- Link to custom CSS & Icons -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <h1>Reset Password</h1>

            <!-- Error Messages -->
            @if ($errors->any())
                <ul style="color: red; margin-bottom: 10px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <!-- Success or Error Alerts -->
            @if (session('status'))
                <p style="color: green;">{{ session('status') }}</p>
            @endif

            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="input-box">
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $email ?? '') }}" 
                       placeholder="Email" 
                       required>
            </div>

            <!-- New Password -->
            <div class="input-box">
                <input type="password" 
                       name="password" 
                       placeholder="New Password" 
                       required>
            </div>

            <!-- Confirm Password -->
            <div class="input-box">
                <input type="password" 
                       name="password_confirmation" 
                       placeholder="Confirm Password" 
                       required>
            </div>

            <button type="submit" class="btn">Reset Password</button>

            <div class="register-link">
                <p>Back to <a href="/login-page">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
