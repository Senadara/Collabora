@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="slide-container">
        <div class="slide-content">
            <br><br><br>
            <div class="judul2">
                <h1><b>Hi, {{ session('account')['name'] }}!</b></h1>
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

            <form action="{{ route('event.search') }}" method="GET" class="d-flex col-4" target="_self">
                <input class="form-control me-2" type="text" name="search" placeholder="Search Event">
                <button class="btn bg-dark text-white" type="submit">Search</button>
            </form>

            <br>
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
                                <button class="btn btn-volunteer" data-bs-toggle="modal" data-bs-target="#modalEventRegist{{ $event->id }}">Volunteer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalEventRegist{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEventRegistLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form name="formEventRegist" action="{{ route('regist.event', ['event' => $event->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Registation Form</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Masukkan nomor telepon">
                                        </div>
                                        <div class="mb-3">
                                            <label for="experience" class="form-label">Pengalaman</label>
                                            <input type="text" class="form-control" name="experience" placeholder="Masukkan pengalaman">
                                        </div>
                                        <div class="mb-3">
                                            <label for="cv" class="form-label">Upload CV</label>
                                            <input type="file" class="form-control" name="cv" accept=".pdf,.doc,.docx">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('form[name="formEventRegist"]').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: new FormData(form),
            })
            .then(async response => {
                const data = await response.json(); // Ambil data meskipun status bukan 200

                if (response.ok && data.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'You have successfully registered for the event.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => window.location.href = "/dashboard");
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat mendaftar.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Gagal menghubungi server.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script>
@endpush

