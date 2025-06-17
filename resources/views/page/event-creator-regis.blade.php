@extends('layouts.main')

@section('content')
<br>
<br>
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

            <div class="form-group" style="margin-bottom:1.2rem;">
                <label for="ktp_photo" style="font-weight:600; display:block; margin-bottom:0.5rem;">
                    Foto KTP:
                </label>
                <input 
                    type="file" 
                    name="ktp_photo" 
                    id="ktp_photo"
                    accept="image/*" 
                    class="form-control" 
                    style="padding:0.5rem; border:1px solid #ced4da; border-radius:4px;"
                    {{ $isApproved ? 'disabled' : 'required' }}>
            </div>

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label for="selfie_photo" style="font-weight:600; display:block; margin-bottom:0.5rem;">
                    Foto Selfie dengan KTP:
                </label>
                <input 
                    type="file" 
                    name="selfie_photo" 
                    id="selfie_photo"
                    accept="image/*" 
                    class="form-control" 
                    style="padding:0.5rem; border:1px solid #ced4da; border-radius:4px;"
                    {{ $isApproved ? 'disabled' : 'required' }}>
            </div>

            <div style="margin-top:2rem; text-align:center;">
               <button 
                    type="submit"
                    class="btn"
                    style="
                        padding:0.7rem 2.5rem;
                        background:{{ $isApproved ? '#ccc' : 'rgba(15, 24, 37, 0.8)' }};
                        color:white;
                        border:none;
                        border-radius:5px;
                        font-size:1rem;
                        font-weight:600;
                        cursor:{{ $isApproved ? 'not-allowed' : 'pointer' }};
                        transition:background 0.2s;
                    "
                    {{ $isApproved ? 'disabled' : '' }}
                >
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
