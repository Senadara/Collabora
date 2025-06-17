  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Biodata Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    body {
      font-family: 'Trebuchet MS', 'threbucket', sans-serif;
      background: #f4f6fb;
      padding: 0;
      margin: 0;
    }
    .biodata-card {
      background: #fff;
      max-width: 480px;
      margin: 2rem auto 0 auto;
      padding: 2.5rem 2rem 2rem 2rem;
      border-radius: 14px;
      box-shadow: 0 6px 32px rgba(52,144,220,0.08), 0 1.5px 6px rgba(0,0,0,0.04);
    }
    .biodata-title {
      margin-bottom: 1.2rem;
      color:rgba(34, 40, 49, 0.8);
      text-align: center;
      font-weight: 600;
      font-size: 2.1rem;
      margin-top: 2.2rem;
    }
      form div {
        margin-bottom: 1.1rem;
      }
      label {
        font-weight: 500;
        display: block;
        margin-bottom: 0.4rem;
        color: #333;
      }
      input, select {
        width: 100%;
        max-width: 100%;
        padding: 8px 10px;
        border: 1px solid #dbeafe;
        border-radius: 6px;
        background: #f8fafc;
        font-size: 1rem;
        transition: border 0.2s;
      }
      input:focus, select:focus {
        border-color:rgba(34, 40, 49, 0.8);
        outline: none;
        background: #fff;
      }
      button {
        padding: 14px 0;
        width: 100%;
        border: none;
        border-radius: 6px;
        background-color:rgba(34, 40, 49, 0.8);
        color: white;
        font-size: 1.08rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.18s;
        margin-top: 0.7rem;
      }
      button:hover {
        background-color:rgb(25, 24, 35);
      }
      .btn-secondary {
        background-color: #6c757d;
        margin-top: 0.7rem;
        margin-bottom: 0.7rem;
        padding: 14px 0;
      }
      .btn-secondary:hover {
        background-color: #495057;
      }
      @media (max-width: 600px) {
        .biodata-card {
          padding: 1.2rem 0.7rem;
          margin: 1.5rem 0.2rem;
        }
        .biodata-title {
          font-size: 1.3rem;
          margin-top: 1.5rem;
        }
      }
    </style>
    @extends('layouts.main')
  </head>
  <body>
    @section('content')
    <br>
      <div class="biodata-title">Lengkapi Biodata</div>
      <div class="biodata-card">
       <form method="POST" action="{{ route('biodata.store') }}" id="biodataForm" data-is-update="{{ $biodata ? 'true' : 'false' }}">
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
            <a href="/daftar-creator" class="btn-secondary" style="display:block;text-align:center;text-decoration:none;">
              🚀 Upgrade Account
            </a>
          @endif
        </form>
      </div>
    @endsection
  </body>
  </html>
