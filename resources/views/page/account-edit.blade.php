@extends('layouts.main')
@section('content')
    <br><br><br>
    <div class="w-50 center border px-3 py-3 mx-auto bg-light p-3 ktk">
        <h1>Edit Account</h1>

        {{-- Menampilkan pesan error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Menampilkan pesan sukses --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "/admin/manage-account";
                });
            </script>
        @endif

        <form action="/account/{{ $account->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input class="form-control form-control-sm @error('name') is-invalid @enderror" 
                       type="text" name="name" id="name"
                       value="{{ old('name', $account->name) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control form-control-sm @error('email') is-invalid @enderror"
                       type="email" name="email" id="email"
                       value="{{ old('email', $account->email) }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control form-control-sm @error('password') is-invalid @enderror"
                       type="password" name="password" id="password"
                       placeholder="Masukkan password baru">
            </div>

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-warning" type="submit">Update</button>
                <button type="button" onclick="window.history.back();" class="btn btn-danger">Cancel</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
