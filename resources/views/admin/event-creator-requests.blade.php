@extends('layouts.main')

@section('content')
<br>
<br>
<div class="d-flex align-items-center justify-content-between mb-4 mt-4" style="padding-left: 0; padding-right: 0;">
    <div class="flex-grow-1 text-start">
        <h1 class="mb-0">Pengajuan Event Creator</h1>
    </div>
</div>

<table class="table table-light table-hover">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">Email</th>
            <th scope="col">KTP</th>
            <th scope="col">Selfie</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $counter = 1;
        @endphp
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $counter++ }}</th>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->account->email }}</td>
            <td><a href="{{ asset('storage/' . $user->ktp_photo) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat KTP</a></td>
            <td><a href="{{ asset('storage/' . $user->selfie_photo) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Selfie</a></td>
            <td>{{ ucfirst($user->creator_request_status) }}</td>
            <td>
                <form method="POST" action="{{ route('creator.approve', $user->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-success btn-sm">Terima</button>
                </form>
                <form method="POST" action="{{ route('creator.reject', $user->id) }}" class="d-inline mt-1">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Tolak</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
