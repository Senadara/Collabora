<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Link -->
    <link rel="stylesheet" href="{{ '../css/register.css' }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <form id="registerForm" action="/account" method="POST" enctype="multipart/form-data">
            @csrf
            <h1>Register</h1>

            <div class="input-box">
                <input class="form-controll form-control-sm" type="text" name="name" id="name"
                    placeholder="Nama" required>
            </div>

            <div class="input-box">
                <input class="form-controll form-control-sm" type="email" name="email" id="email"
                    placeholder="Email" required>
            </div>

            <div class="input-box">
                <input class="form-controll form-control-sm" type="password" name="password" id="password"
                    placeholder="Password" required>
            </div>

            <div class="input-box">
                <input class="form-controll form-control-sm" type="password" name="password_confirmation"
                    id="passwordconfirm" placeholder="Confirm Password" required>
            </div>

            <button class="btn" type="submit">Create Account</button>

            <div class="register-link">
                <p>Already have an account? <a href="/account">Login</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        if (data.status === 'error' && data.messages) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal membuat akun!',
                                html: data.messages.map(msg => `<div>${msg}</div>`).join('')
                            });
                        } else {
                            Swal.fire('Gagal', 'Terjadi kesalahan server.', 'error');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: data.message
                        }).then(() => {
                            window.location.href =
                            "/account"; // redirect ke login atau halaman akun
                        });
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Gagal terhubung ke server.', 'error');
                });
        });
    </script>

</body>

</html>
