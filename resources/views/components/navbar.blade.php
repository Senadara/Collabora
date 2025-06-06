<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <!-- Tambahkan library SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Start Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
       <a class="navbar-brand me-auto d-flex align-items-center" href="/dashboard">
            <img src="/img/logo2.png" alt="Logo">
            <b>Collabora</b>
        </a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><b>Collabora</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="/dashboard">Dashboard</a>
                    </li>
                    @if (session('account')['role'] == 'user')
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="/event">Event</a>
                        </li>
                    @endif
                    @if (session('account')['role'] == 'user')
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="/#">Rewarding</a>
                        </li>
                    @endif
                     @if (session('account')['role'] == 'user')
                        <li class="nav-item">
                           <a class="nav-link mx-lg-2" href="#">Account</a>
                        </li>
                    @endif
                    @if (session('account')['role'] == 'admin')
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="/admin/manage-account">Manage Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="/admin/manage-event">Manage Event</a>
                        </li>
                    @endif
                </ul>
                <!-- Panggil fungsi konfirmasi saat mengklik logout -->
                <a href="javascript:void(0)" class="logout-button" onclick="confirmLogout()">Logout</a>
            </div>
        </div>
        <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
<!-- End Navbar -->

<!-- JS -->
<script>
    // Fungsi untuk menampilkan SweetAlert2 konfirmasi
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman logout jika pengguna menekan "Ya"
                window.location.href = '/logout';
            }
        })
    }
</script>

</body>
</html>
