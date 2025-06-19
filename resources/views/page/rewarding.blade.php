{{-- resources/views/page/rewarding.blade.php --}}
@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="slide-container">
        <div class="slide-content">
            <br><br><br>
            <div class="judul2">
                <h1><b>Hi, {{ auth()->user()->name }}!</b></h1>
                <p class="text-muted">Berikut event yang sudah kamu ikuti sebagai volunteer.</p>
            </div>

            <div class="heading mt-4 mb-3">
                <h2><b>Event Kamu</b></h2>
            </div>

            @if ($participations->isEmpty())
                <div class="alert alert-info">Kamu belum mengikuti event apa pun sebagai volunteer.</div>
            @else
                <div class="container py-3">
                    <div class="row gx-4 gy-4">
                        @foreach ($participations as $regist)
                            @php
                                $event = $regist->event;
                                // $isRewarded = (bool) $regist->reward;
                            @endphp
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ $event->event_image }}" class="card-img-top" alt="{{ $event->name_event }}"
                                        style="object-fit: cover; height: 200px;">

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $event->name_event }}</h5>
                                        <h6 class="card-subtitle text-muted mb-2">
                                            <i class="bi bi-geo-alt-fill me-1"></i>{{ $event->location }}
                                        </h6>

                                        <p class="mb-2"><small class="text-muted">Status:
                                                <strong>Accepted</strong></small></p>

                                        @if ($regist->reward == "true")
                                            <span class="badge bg-success mb-2">Rewarded</span>
                                        @else
                                            <span class="badge bg-secondary mb-2">Belum Dapat Reward</span>
                                        @endif

                                        <div class="mt-auto">
                                            <a href="/event/show/{{ $event->id }}"
                                                class="btn btn-outline-primary w-100">Lihat Detail Event</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
