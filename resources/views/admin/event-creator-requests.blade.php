@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Pengajuan Event Creator</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>KTP</th>
                <th>Selfie</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->account->email }}</td>
                <td><a href="{{ asset('storage/' . $user->ktp_photo) }}" target="_blank">Lihat KTP</a></td>
                <td><a href="{{ asset('storage/' . $user->selfie_photo) }}" target="_blank">Lihat Selfie</a></td>
                <td>{{ ucfirst($user->creator_request_status) }}</td>
                <td>
                    <form method="POST" action="{{ route('creator.approve', $user->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Terima</button>
                    </form>
                    <form method="POST" action="{{ route('creator.reject', $user->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mt-1">Tolak</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
