@extends('layouts.main')

@section('content')
    <br><br><br>
    <div class="w-50 center border px-3 py-3 mx-auto bg-light p-3 ktk">
        <h1>Create Event</h1>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        {{-- Pesan error global --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/event" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name Event</label>
                <input class="form-control form-control-sm @error('name_event') is-invalid @enderror" type="text"
                       name="name_event" id="name" value="{{ old('name_event') }}" required>
                @error('name_event')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input class="form-control form-control-sm @error('location') is-invalid @enderror" type="text"
                       name="location" id="location" value="{{ old('location') }}" required>
                @error('location')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex mb-3">
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label for="date">Date</label>
                    </div>
                    <input type="date" name="date" id="date"
                           class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                    @error('date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3 mx-4">
                    <label for="image" class="form-label mb-3">Upload Logo</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image-file"
                           name="image">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description Event</label>
                <textarea class="form-control @error('description_event') is-invalid @enderror" name="description_event"
                          id="description" required rows="3">{{ old('description_event') }}</textarea>
                @error('description_event')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-center gap-2">
                <a href="/event"><button type="button" class="btn btn-danger">Cancel</button></a>
                <button class="btn btn-success" type="submit">Create</button>
            </div>
        </form>
    </div>
@endsection
