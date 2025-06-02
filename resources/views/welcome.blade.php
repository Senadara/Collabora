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

</head>
<body class="blanding">
    <div class="wrapper">
        <div class="nav">
            <div class="logo">
                <a>
                    <img src="img/logo.png" alt="Collabora Logo" style="height: 40px;" class="logo-img">
                    <p lass="logo-text" >Collabora</p>
                </a>
            </div>
        </div>
        <div class="header">
            <h1>Coll<span>abora</span></h1>
            <br>
        </div>

        <div class="content-header">
            <br>
            <p>Platform digital yang menghubungkan relawan dengan berbagai
                kesempatan untuk membantu komunitas, lingkungan, atau kegiatan 
                sosial lainnya.
                <br>
                <br>
                <br>
                <input class="login-btn"
                type="button" value="Login">
            </p>
        </div>

        <div class="col-img">
            <img src="img/potret2.jpg" alt="" srcset="">
        </div>
    </div>
</body>
<script>
    document.querySelector('.login-btn').addEventListener('click', function() {
        window.location.href = '/account';
    });
</script>

</html>