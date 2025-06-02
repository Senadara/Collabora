@extends('layouts.main')
@section('content')
    <br>
    <br>
    <br>
    <div class="d-flex align-items-center">
        <h1 class="mb-0">Manage Account</h1>
        <a href="{{ route('account.create') }}" class="btn btn-dark ms-auto">Create Account</a>
    </div>
    <br>
    <table class="table table-light table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1; // Initialize a counter variable
            @endphp
            @foreach ($accountList as $item)
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td> <a class="btn btn-outline-dark" href="{{ route('account.edit', $item->id) }}">Edit</a></td>
                    <td>
                        <!-- Form untuk menghapus akun -->
                        <form action="{{ route('account.destroy', $item->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script to Handle Delete Button Click -->
    <script>
        // Ambil semua formulir penghapusan
        const deleteForms = document.querySelectorAll('.delete-form');

        // Tambahkan event listener untuk setiap formulir penghapusan
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah aksi default formulir (pengiriman POST)

                // Ambil ID akun dari formulir
                const accountId = this.getAttribute('action').split('/').pop();

                // Tampilkan konfirmasi SweetAlert2
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this account!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan penghapusan ke server
                        fetch(this.getAttribute('action'), {
                            method: 'POST', // Ubah metode menjadi POST
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ _method: 'DELETE', _token: '{{ csrf_token() }}' }) // Kirim _method dan _token
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            // Jika berhasil, tampilkan SweetAlert2 sukses
                            return Swal.fire({
                                title: 'Deleted!',
                                text: 'Account has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                // Reload halaman setelah menekan OK
                                if (result.isConfirmed) {
                                    window.location.href = "/admin/manage-account"; // Redirect ke /admin/manage-account
                                }
                            });
                        })
                        .catch(error => {
                            // Tangani kesalahan jika ada
                            console.error('There was an error!', error);
                            // Tampilkan SweetAlert2 jika terjadi kesalahan
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error while deleting the account.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });

            });
        });
    </script>
@endsection
