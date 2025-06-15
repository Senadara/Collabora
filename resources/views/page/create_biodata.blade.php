


  <style>
    body { font-family: Arial, sans-serif; padding: 40px;}
    form div { margin-bottom: 12px; }
    label { font-weight: bold; display: block; }
    form {margin-top: 5rem;}
    input, select { width: 100%; max-width: 400px; padding: 6px; }
    button {
      padding: 10px 20px; margin-top: 20px; border: none; border-radius: 4px;
      background-color: #3490dc; color: white; cursor: pointer;
    }
    .btn-secondary { background-color: #6c757d; margin-bottom: 20px; }
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">



@extends('layouts.main')

@section('content')

<body>

    {{-- <a href="/dashboard">
        <button type="button" class="btn-secondary">← Kembali ke Dashboard</button>
    </a> --}}

    <form id="biodataForm" data-is-update="{{ $biodata ? 'true' : 'false' }}">
      <h2>Lengkapi Biodata</h2>
    @csrf
    <input type="hidden" name="account_id" value="{{ $accountId ?? '' }}">

    <div>
      <label>Nama Lengkap:</label>
      <input type="text" name="full_name" required value="{{ $biodata->full_name ?? '' }}">
    </div>

    <div>
      <label>Jenis Kelamin:</label>
      <select name="gender">
        <option value="">Pilih</option>
        <option value="L" {{ (isset($biodata) && $biodata->gender == 'L') ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ (isset($biodata) && $biodata->gender == 'P') ? 'selected' : '' }}>Perempuan</option>
      </select>
    </div>

    <div>
      <label>Tanggal Lahir:</label>
      <input type="date" name="birth_date" value="{{ $biodata->birth_date ?? '' }}">
    </div>

    <div>
      <label>No. HP:</label>
      <input type="text" name="phone_number" value="{{ $biodata->phone_number ?? '' }}">
    </div>

    <div>
      <label>Alamat:</label>
      <input type="text" name="address" value="{{ $biodata->address ?? '' }}">
    </div>

    <div>
      <label>Universitas:</label>
      <input type="text" name="university" value="{{ $biodata->university ?? '' }}">
    </div>

    <div>
      <label>Jurusan:</label>
      <input type="text" name="major" value="{{ $biodata->major ?? '' }}">
    </div>

    <div>
      <label>Semester:</label>
      <input type="text" name="semester" value="{{ $biodata->semester ?? '' }}">
    </div>

    <div>
      <label>Instagram:</label>
      <input type="text" name="instagram_handle" value="{{ $biodata->instagram_handle ?? '' }}">
    </div>

    <button type="submit">{{ $biodata ? 'Perbarui Biodata' : 'Kirim Biodata' }}</button>

    @if ($biodata)
    <a href="/daftar-creator">
      <button type="button" class="btn-secondary">🚀 Upgrade Account</button>
    </a>
  @endif
  </form>
@endsection

  <script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('biodataForm');
  console.log(form); // <-- Di sini
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      const isUpdate = this.dataset.isUpdate === 'true';

      fetch(isUpdate ? '/biodata/update' : '/biodata/create', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
      })
      .then(async response => {
        let data = {};
        try {
          data = await response.json();
        } catch (e) {
          console.warn('Gagal parse JSON:', e);
        }

        if (response.ok) {
          Swal.fire({
            title: 'Sukses!',
            text: data.message || 'Berhasil.',
            icon: 'success'
          }).then(() => {
            window.location.href = '/dashboard';
          });
        } else {
          Swal.fire({
  title: 'Gagal!',
  html: generateErrorHtml(data),
  icon: 'error'
});

function generateErrorHtml(data) {
  if (Array.isArray(data.message)) {
    return data.message.map(msg => `<p>${msg}</p>`).join('');
  }

  if (typeof data.errors === 'object') {
    return Object.values(data.errors)
      .flat()
      .map(msg => `<p>${msg}</p>`)
      .join('');
  }

  return `<p>${data.message || 'Terjadi kesalahan.'}</p>`;
}

        }
      })
      .catch(err => {
        console.error('Catch error:', err);
        Swal.fire('Error!', 'Terjadi kesalahan saat mengirim data.', 'error');
      });
    });
  } else {
    console.warn('Form #biodataForm tidak ditemukan');
  }
});
</script>



  {{-- <script>
    document.getElementById('biodataForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      const isUpdate = this.dataset.isUpdate === 'true';

      fetch(isUpdate ? '/biodata/update' : '/biodata/create', {
        method: 'POST',
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
            title: 'Sukses!',
            text: data.message,
            icon: 'success'
          }).then(() => {
            window.location.href = '/dashboard';
          });
        } else {
          Swal.fire({
            title: 'Gagal!',
            html: (data.message || data.messages || []).map(msg => `<p>${msg}</p>`).join(''),
            icon: 'error'
          });
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire('Error!', 'Terjadi kesalahan saat mengirim data.', 'error');
      });
    });
  </script> --}}
</body>
</html>
