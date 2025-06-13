@extends('layouts.main')

@section('content')
<h2>Daftar Sebagai Event Creator</h2>

<form action="{{ route('creator.register') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Upload Foto KTP</label>
        <input type="file" name="ktp_photo" accept="image/*" required>
    </div>
    <div>
        <label>Upload Foto Selfie dengan KTP</label>
        <input type="file" name="selfie_photo" accept="image/*" required>
    </div>
    <button type="submit">Ajukan Sebagai Event Creator</button>
</form>
@endsection
    