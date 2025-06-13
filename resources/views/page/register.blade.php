<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ '../css/register.css' }}" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    .form-step {
      display: none;
    }

    .form-step-active {
      display: block;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <h1>Register</h1>
    <form id="registerForm" action="/account" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Step 1: Account Info -->
      <div class="form-step form-step-active">
        <h2>Account Info</h2>
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
        <button type="button" class="btn btn-next">Next</button>
      </div>

      <!-- Step 2: Biodata -->
      <div class="form-step">
        <h2>Biodata</h2>
        <div class="input-box">
          <input type="text" name="full_name" placeholder="Full Name" required>
        </div>
        <div class="input-box">
          <select name="gender" required>
            <option value="" disabled selected>Gender</option>
            <option value="women">Women</option>
            <option value="man">Man</option>
          </select>
        </div>
        <div class="input-box">
          <input type="date" name="birth_date" placeholder="Birth Date">
        </div>
        <div class="input-box">
          <input type="text" name="phone_number" placeholder="Phone Number">
        </div>
        <div class="input-box">
          <input type="text" name="address" placeholder="Address">
        </div>
        <div class="input-box">
          <input type="text" name="university" placeholder="University">
        </div>
        <div class="input-box">
          <input type="text" name="major" placeholder="Major">
        </div>
        <div class="input-box">
          <input type="text" name="semester" placeholder="Semester">
        </div>
        <div class="input-box">
          <input type="text" name="instagram_handle" placeholder="Instagram">
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 20px; gap: 15px;">
          <button type="button" class="btn btn-back" style="flex:1;">Back</button>
          <button type="submit" class="btn" style="flex:1;">Register</button>
        </div>
      </div>

      <div class="register-link" style="margin-top: 20px; text-align: center;">
        <p>Already have an account? <a href="/login-page">Login</a></p>
      </div>
    </form>
  </div>

  {{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
      const nextBtn = document.querySelector('.btn-next');
      const backBtn = document.querySelector('.btn-back');
      const formSteps = document.querySelectorAll('.form-step');
      const form = document.getElementById('registerForm');
      let currentStep = 0;

      // Next button click (Step 1 validation)
      nextBtn.addEventListener('click', () => {
        const step1Inputs = formSteps[0].querySelectorAll('input[required]');
        let valid = true;
        step1Inputs.forEach(input => {
          if (!input.value.trim()) {
            valid = false;
            input.style.borderColor = 'red';
          } else {
            input.style.borderColor = '';
          }
        });
        if (!valid) return;

        formSteps[currentStep].classList.remove('form-step-active');
        currentStep++;
        formSteps[currentStep].classList.add('form-step-active');

        // Autofocus ke Full Name di step 2
        const fullNameInput = formSteps[currentStep].querySelector('input[name="full_name"]');
        if (fullNameInput) {
          fullNameInput.focus();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
      });

      // Back button click
      backBtn.addEventListener('click', () => {
        formSteps[currentStep].classList.remove('form-step-active');
        currentStep--;
        formSteps[currentStep].classList.add('form-step-active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });

      // Form submit
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        const fullNameInput = form.querySelector('input[name="full_name"]');
        if (!fullNameInput.value.trim()) {
          Swal.fire({
            title: "Error!",
            text: "Full Name is required",
            icon: "error",
            confirmButtonText: "OK",
          });
          fullNameInput.style.borderColor = "red";
          return;
        } else {
          fullNameInput.style.borderColor = "";
        }

        fetch("/account", {
          method: "POST",
          body: new FormData(form),
          headers: {
            'Accept': 'application/json'
          },
        })
          .then(response => response.json())
          .then(data => {
            if (data.message) {
              Swal.fire({
                title: "Success!",
                text: data.message,
                icon: "success",
                confirmButtonText: "OK",
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "/login-page";
                }
              });
            } else if (data.error) {
              Swal.fire({
                title: "Error!",
                text: data.error,
                icon: "error",
                confirmButtonText: "OK",
              });
            }
          })
          .catch(error => {
            console.error("Unexpected error:", error);
            Swal.fire({
              title: "Error!",
              text: "Unexpected error occurred.",
              icon: "error",
              confirmButtonText: "OK",
            });
          });
      });
    });
  </script> --}}

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const nextBtn = document.querySelector('.btn-next');
    const backBtn = document.querySelector('.btn-back');
    const formSteps = document.querySelectorAll('.form-step');
    const form = document.getElementById('registerForm');
    let currentStep = 0;

    // Next button click
    nextBtn.addEventListener('click', () => {
      const step1Inputs = formSteps[0].querySelectorAll('input[required]');
      let valid = true;
      step1Inputs.forEach(input => {
        if (!input.value.trim()) {
          valid = false;
          input.style.borderColor = 'red';
        } else {
          input.style.borderColor = '';
        }
      });
      if (!valid) return;

      formSteps[currentStep].classList.remove('form-step-active');
      currentStep++;
      formSteps[currentStep].classList.add('form-step-active');
      const fullNameInput = formSteps[currentStep].querySelector('input[name="full_name"]');
      if (fullNameInput) {
        fullNameInput.focus();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });

    // Back button click
    backBtn.addEventListener('click', () => {
      formSteps[currentStep].classList.remove('form-step-active');
      currentStep--;
      formSteps[currentStep].classList.add('form-step-active');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Submit form
    form.addEventListener('submit', function (event) {
      event.preventDefault();

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
            title: "Success!",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            window.location.href = "/login-page";
          });
        } else if (response.status === 422) {
          Swal.fire({
            title: "Validation Error!",
            html: data.messages.map(msg => `<p>${msg}</p>`).join(''),
            icon: "error",
            confirmButtonText: "OK",
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: "Unexpected server error",
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      })
      .catch(error => {
        console.error(error);
        Swal.fire({
          title: "Error!",
          text: "Something went wrong!",
          icon: "error",
          confirmButtonText: "OK",
        });
      });
    });
  });
</script>

</body>

</html>
