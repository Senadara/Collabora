@extends('layouts.main')

@section('content')
<br>
<br>
   <div class="d-flex align-items-center justify-content-between mb-4 mt-4" style="padding-left: 0; padding-right: 0;">

        <div class="flex-grow-1 text-start">
            <h1 class="mb-0">Manage Account</h1>
        </div>
        <div>
            <a href="{{ route('account.create') }}" class="btn btn-dark">Create Account</a>
        </div>
    </div>

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
                $counter = 1;
            @endphp
            @foreach ($accountList as $item)
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a class="btn btn-outline-dark" href="{{ route('account.edit', $item->id) }}">Edit</a>
                    </td>
                    <td>
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Delete Confirmation Script -->
    <script>
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this account!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(this.getAttribute('action'), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return Swal.fire({
                                title: 'Deleted!',
                                text: 'Account has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "/admin/manage-account";
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
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
