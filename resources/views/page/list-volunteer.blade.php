@extends('layouts.main')
@section('content')
<br>
<br>
<br>
<div class="d-flex align-items-center">
  <h1 class="mb-0">Manage Volunteer List</h1>
    </div>
    <div class="mt-5 border p-2 rounded-1 bg-light">
        <table id="example" class="hover" style="width:100%">
            <thead>
    <tr>
        <th>Nama Volunteer</th>
        <th>Email</th>
        <th>No.HP</th>
        <th>Experience</th>
        <th>Status</th>
        <th>CV</th> <!-- Tambah kolom CV -->
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($volunteerList as $item)
        @if ($item->status == 'request')
            <tr>
                <td>{{ $item->account['name'] }}</td>
                <td>{{ $item->account['email'] }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->experience }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    @if($item->cv_path)
                        <a href="{{ asset('storage/' . $item->cv_path) }}" target="_blank" class="btn btn-primary btn-sm">
                            View CV
                        </a>
                    @else
                        <span class="text-muted">No CV</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-danger btn-sm" href="{{ route('deny.volunteer', ['id' => $item->id]) }}">deny</a>
                    <a class="btn btn-success btn-sm" href="{{ route('accept.volunteer', ['id' => $item->id]) }}">accept</a>
                </td>
            </tr>
        @endif
    @endforeach
</tbody>

        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
@endpush

@push('css')
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
@endpush
