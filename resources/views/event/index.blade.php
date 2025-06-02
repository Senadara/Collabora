@extends('layouts.main')

@section('content')

    <br>
    <br>
    <br>
   <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Event</h1>
    <a href="event/create" class="btn btn-dark">Create Data</a>
</div>

<div class="bg-light rounded px-3 py-2">
    <table id="eventTable" class="table bg-light border px-3 evt">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th>Name Event</th>
                <th>Location</th>
                <th>Date</th>
                <th>Deskripsion</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1; // Initialize a counter variable
            @endphp
            {{-- Cuma coba ngeluarin data  --}}
            @foreach ($eventList as $item)
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $item->name_event }}</td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->description_event }}</td>
                  <td>
                        <div class="d-flex flex-wrap gap-1">
                            <a class="btn btn-outline-secondary" href="/event/show/{{ $item->id }}">Show</a>
                            <a class="btn btn-outline-secondary" href="/event/edit/{{ $item->id }}">Edit</a>
                            <a class="btn btn-outline-secondary" href="/sponsorship/{{ $item->id }}">Request</a>
                            <a class="btn btn-outline-secondary" href="{{ route('show.volunteer', ['event' => $item->id]) }}">Volunteer</a>
                            <a class="btn btn-outline-secondary" href="{{ route('show.accepted.volunteer', ['event' => $item->id]) }}">Member</a>
                            <button class="btn btn-outline-danger delete-btn" data-id="{{ $item->id }}">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script to Handle Delete Button Click -->
    <script>
        // Ambil semua tombol delete
        const deleteButtons = document.querySelectorAll('.delete-btn');

        // Tambahkan event listener untuk setiap tombol delete
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID acara dari atribut data
                const eventId = this.getAttribute('data-id');

                // Tampilkan konfirmasi SweetAlert2
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this event!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke rute penghapusan jika pengguna menekan tombol "Yes, delete it!"
                        window.location.href = `/event/${eventId}`;
                    }
                });
            });
        });
    </script>
@endsection

@push('scripts')
    <!-- Include DataTables JavaScript library -->
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#eventTable').DataTable();
        });
    </script>
@endpush

@push('css')
    <!-- Include DataTables CSS library -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
@endpush
