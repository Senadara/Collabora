<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <div class="wrapper">
    <h1>Register</h1>

    <form id="registerForm">
      @csrf
      <div class="input-box">
        <input type="text" name="name" placeholder="Nama" required>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="input-box">
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
      </div>

      <button type="submit" class="btn">Register</button>

      <div class="register-link" style="margin-top: 20px; text-align: center;">
        <p>Already have an account? <a href="/login-page">Login</a></p>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById('registerForm');

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("/account", {
          method: "POST",
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: formData
        })
        .then(async response => {
          const data = await response.json();

          if (response.ok) {
            Swal.fire({
              title: "Berhasil!",
              text: data.message || "Akun berhasil dibuat.",
              icon: "success",
              confirmButtonText: "OK"
            }).then(() => {
              window.location.href = "/login-page";
            });
          } else if (response.status === 422) {
            Swal.fire({
              title: "Validasi Gagal!",
              html: data.messages.map(msg => `<p>${msg}</p>`).join(''),
              icon: "error",
              confirmButtonText: "OK",
            });
          } else {
            Swal.fire({
              title: "Error!",
              text: "Terjadi kesalahan pada server.",
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire({
            title: "Error!",
            text: "Gagal menghubungi server.",
            icon: "error",
            confirmButtonText: "OK",
          });
        });
      });
    });
  </script>
</body>

</html>
