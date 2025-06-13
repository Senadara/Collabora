@extends('layouts.main')

@section('content')

    <br>
    <br>
    <br>
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Rewarding</h1>
</div>

<div class="bg-light rounded px-3 py-2">
    <table id="eventTable" class="table bg-light border px-3 evt" >
        <thead>
            <tr>
                <th scope="col">No</th>
                <th>Name Event</th>
                <th>Location</th>
                <th>Date</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1; // Initialize a counter variable
            @endphp
            {{-- Cuma coba ngeluarin data  --}}
            @foreach ($eventList as $item)     <!-- edit show event berdasarkan event yang didaftar -->
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $item->name_event }}</td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->description_event }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <a class="btn btn-outline-secondary" href="/event/show/{{ $item->id }}">Show</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
