<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <!-- Link -->
    <link rel="stylesheet" href="{{ 'css/style.css' }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

</head>

<body class="blanding">
    <div class="wrapper">
        <div class="nav">
            <div class="logo">
                <a>
                    <img src="img/logo2.png" alt="Collabora Logo" style="height: 40px;" class="logo-img">
                    <p class="logo-text" >Collabora</p>
                </a>
            </div>
        </div>
        <div class="header">
            <h1>Coll<span>abora</span></h1>
            <br>
        </div>

       <div class="content-header">
            <br><br><br><br>
            <p>
                Platform digital yang menghubungkan relawan dengan berbagai
                kesempatan untuk membantu komunitas, lingkungan, atau kegiatan 
                sosial lainnya.
                <br><br>
            </p>
            <div class="button-group">
                <input class="event-btn" type="button" value="Lihat Event">
                <input class="login-btn" type="button" value="Login">
            </div>
        </div>


        <div class="col-img">
            <img src="img/potret2.jpg" alt="" srcset="">
        </div>

        </p>
</div> 

        <!-- About Us Section -->
<br>
<br>
    <h1>Get to Know Collabora</h1>
        <div class="dashboard-cards" id="card-section">
            <div class="cards-wrapper">
                <div class="card">
                    <i class="ri-user-heart-line card-icon"></i>
                    <h3>Relawan Aktif</h3>
                    <p>Banyak relawan dari berbagai latar belakang sedang aktif 
                        berkontribusi dalam aksi sosial, lingkungan, hingga edukasi masyarakat.</p>
                </div>

                <div class="card">
                    <i class="ri-calendar-check-line card-icon"></i>
                    <h3>Event Terdekat</h3>
                    <p>Beragam kegiatan sukarela akan segera diselenggarakan dan 
                        terbuka untuk siapa saja yang ingin terlibat secara langsung.</p>
                </div>

                <div class="card">
                    <i class="ri-community-line card-icon"></i>
                    <h3>Komunitas Terbuka</h3>
                    <p>Beberapa komunitas sosial sedang membuka ruang kolaborasi bagi 
                        relawan baru yang ingin tumbuh dan berdampak bersama.</p>
                </div>
            </div>
        </div>
</div>

<!-- Upcoming Events Section -->
<br>
<br>
    <h1>Upcoming Event</h1>
        <div class="card-event" id="card-event">
            @foreach ($latestEvents as $event)
                <div class="card">
                    <img src="{{ asset($event->event_image) }}" alt="{{ $event->name_event }}" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">{{ $event->name_event }}</h3>
                        <a href="{{ url('/account') }}" class="btn btn-custom-view">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>

<!-- Animated Separator Line -->
<hr class="animated-separator" />



<!-- Regsiter -->
        <div class="login-redirect">
        <div class="register-card">
            <div class="card-image">
            <img src="img/potret4.jpg" alt="Join Us" />
            </div>
            <div class="card-content">
            <h3>Ayo, Jadi Relawan dan Berikan Dampak Positif!</h3>
            <p>Yuk daftarkan dirimu sekarang dan bergabung dengan komunitas kami!</p>
            <button onclick="window.location.href='{{ url('/account') }}'">Daftar Sekarang</button>

            </div>
        </div>
    </div>
<br>
<br>
<br>
<footer class="footer-simple">
  <p>© 2025 Collabora. All rights reserved.</p>
</footer>



</body>
<script>
    document.querySelector('.login-btn').addEventListener('click', function() {
        window.location.href = '/account';
    });

      document.querySelector('.login-btn').addEventListener('click', function() {
        window.location.href = '/account';
    });

    document.querySelector('.event-btn').addEventListener('click', function() {
        document.getElementById('card-event').scrollIntoView({ behavior: 'smooth' });
    });
</script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
  const swiper = new Swiper('.swiper', {
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>


</html>