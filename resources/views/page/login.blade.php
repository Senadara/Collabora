<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Link -->
    <link rel="stylesheet" href="{{ 'css/login.css' }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="wrapper">
         <form action="/login" method="POST">
         @csrf
         <h1>Login</h1>

         <div class="input-box">
            <input type="email" value="{{ Session::get('email') }}" name="email" class="form-controll" placeholder="Email">
        </div>

         <div class="input-box">
            <input type="password" name="password" class="form-controll" placeholder="Password">
         </div>

         <button type="submit" class="btn">Login</button>

        <div class="register-link">
            <p>Forgot <a 
            href="/forgot-password"> Password ?</a></p>
        </div>

        <div class="register-link">
            <p>Don't have an account? <a 
            href="/account/create">Create Account</a></p>
        </div>
         </form>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>

</div>
</body>
</html>


