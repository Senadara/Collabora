@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="slide-container">
        <div class="slide-content">
            <br><br><br>
            <div class="judul2">
                <h1><b>Hi, {{ auth()->user()->name }}!</b></h1>
            </div>

            <br>
            <section class="container">
                <div class="slide-wrapper">
                    <div class="slider">
                        <img id="slide-3" src="img/baru1.png" alt="" class="card-img">
                    </div>
                </div>
            </section>

            <br><br>
            <div class="heading">
                <h1><b> Our Event</b></h1>
            </div>

            <form action="{{ route('event.search') }}" method="GET" class="d-flex col-4">
                <input class="form-control me-2" type="text" name="search" placeholder="Search Event">
                <button class="btn bg-dark text-white" type="submit">Search</button>
            </form>

            <br>

            {{-- Trigger to reopen modal on validation error --}}
            @if ($errors->any())
                <input type="hidden" id="openModalId" value="{{ old('event_id') }}">
            @endif

            <div class="card-wrapper">
                @foreach ($events as $event)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $event->event_image }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->name_event }}</h5>
                                <h6 class="card-location">Location : {{ $event->location }}</h6>
                                <br>
                                <a href="/event/show/{{ $event->id }}" class="btn btn-custom-view">View More</a>
                                <button class="btn btn-volunteer" data-bs-toggle="modal"
                                    data-bs-target="#modalEventRegist{{ $event->id }}">Volunteer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalEventRegist{{ $event->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="modalEventRegistLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form name="formEventRegist" action="{{ route('regist.event', ['event' => $event->id]) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Registration Form</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ old('phone') }}"
                                                placeholder="Masukkan nomor telepon">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="experience" class="form-label">Pengalaman</label>
                                            <input type="text"
                                                class="form-control @error('experience') is-invalid @enderror"
                                                name="experience" value="{{ old('experience') }}"
                                                placeholder="Masukkan pengalaman">
                                            @error('experience')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="cv" class="form-label">Upload CV</label>
                                            <input type="file" class="form-control @error('cv') is-invalid @enderror"
                                                name="cv" accept=".pdf,.doc,.docx">
                                            @error('cv')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Reopen modal jika error validasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = document.getElementById('openModalId')?.value;
            if (modalId) {
                const selector = '#modalEventRegist' + modalId;
                new bootstrap.Modal(document.querySelector(selector)).show();
            }
        });
    </script>

    {{-- Tampilkan SweetAlert berdasarkan session --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: {!! json_encode(session('swal_success')) !!},
                    confirmButtonColor: '#3085d6'
                });
            @endif

            @if (session('swal_error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: {!! json_encode(session('swal_error')) !!},
                    confirmButtonColor: '#d33'
                });
            @endif
        });
    </script>
@endpush
