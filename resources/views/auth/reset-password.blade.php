<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
            <!-- Hidden token field -->
            <input type="hidden" name="token" value="{{ $token }}">
            
            <!-- Email field -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $email ?? '') }}" 
                       required 
                       autofocus>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password field -->
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       required>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password field -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation" 
                       class="form-control" 
                       required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Reset Password
                </button>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('account.index') }}';
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        @endif
    </script>
</body>
</html>