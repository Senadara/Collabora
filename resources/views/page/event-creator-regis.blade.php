@extends('layouts.main')

@section('content')
    <div style="max-width:500px; margin:auto; padding:2rem; background:white; border-radius:8px;">

        <h2 style="text-align:center;">Daftar Creator</h2>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33'
                });
            </script>
        @endif

        @php
            $isApproved = $status === 'approved';
            $isPending = $status === 'pending';
            $isRejected = $status === 'rejected';
        @endphp

        @if ($status)
            <div style="margin-bottom: 1rem;">
                @if ($isApproved)
                    <div style="background:#d1e7dd; color:#0f5132; padding:1rem; border-radius:5px;">
                        Status: <strong>Disetujui</strong> — Anda telah menjadi Event Creator.
                    </div>
                @elseif ($isPending)
                    <div style="background:#fff3cd; color:#856404; padding:1rem; border-radius:5px;">
                        Status: <strong>Pending</strong> — Pengajuan sedang diproses.
                    </div>
                @elseif ($isRejected)
                    <div style="background:#f8d7da; color:#842029; padding:1rem; border-radius:5px;">
                        Status: <strong>Ditolak</strong> — Silakan ajukan ulang dokumen Anda.
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('creator.register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="ktp_photo">Foto KTP:</label>
                <input type="file" name="ktp_photo" accept="image/*" {{ $isApproved ? 'disabled' : 'required' }}>
            </div>

            <div style="margin-top:1rem;">
                <label for="selfie_photo">Foto Selfie dengan KTP:</label>
                <input type="file" name="selfie_photo" accept="image/*" {{ $isApproved ? 'disabled' : 'required' }}>
            </div>

            <div style="margin-top:1.5rem;">
                <button type="submit" {{ $isApproved ? 'disabled style=background:#ccc;cursor:not-allowed;' : '' }}>
                    @if ($isRejected)
                        Ajukan Ulang
                    @elseif ($isPending)
                        Perbarui Dokumen
                    @else
                        Kirim Pengajuan
                    @endif
                </button>
            </div>
        </form>
    </div>
@endsection
