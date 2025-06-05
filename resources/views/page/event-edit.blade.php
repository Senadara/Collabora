@extends('layouts.main')

@section('content')
    <div class="w-50 center border px-3 py-3 mx-auto bg-light p-3 ktk mt-5">
        <h1>Edit Event</h1>

        <form action="/event/update/{{ $eventList->id }}" method="POST" enctype="multipart/form-data" id="updateEventForm">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="name" class="form-label">Name Event</label>
                <input class="form-control form-control-sm" type="text" name="name_event" id="name"
                    value="{{ old('name_event', $eventList->name_event) }}">
                @error('name_event')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input class="form-control form-control-sm" type="text" name="location" id="location"
                    value="{{ old('location', $eventList->location) }}">
                @error('location')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input class="form-control" type="date" name="date" id="date"
                    value="{{ old('date', $eventList->date) }}">
                @error('date')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description Event</label>
                <textarea class="form-control" name="description_event" id="description">{{ old('description_event', $eventList->description_event) }}</textarea>
                @error('description_event')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jika ingin menambahkan update gambar juga, tambahkan input file di sini --}}
            {{-- <div class="mb-3">
            <label for="image" class="form-label">Event Image (Optional)</label>
            <input type="file" name="image" class="form-control">
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div> --}}

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-warning" type="submit">Update</button>
                <a href="/event" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert untuk flash message dari session -->
    @if (session('status'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('status') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "/event";
                });
            });
        </script>
    @endif
@endsection
