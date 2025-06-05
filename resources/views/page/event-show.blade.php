<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>

    <!-- Link to CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/showevent.css') }}">

    <!-- Link  JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Link Boostrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Boostrap Date/ Tanggal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 2em;
            position: relative;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            cursor: pointer;
            font-size: 2em;
            padding: 0 0.1em;
            position: relative;
            transition: color 0.2s;
        }

        .star-rating input:checked~label {
            color: #f5b301;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f5b301;
        }

        .star-rating input:checked+label:hover,
        .star-rating input:checked+label:hover~label,
        .star-rating input:checked~label:hover,
        .star-rating input:checked~label:hover~label,
        .star-rating label:hover~input:checked~label {
            color: #f5b301;
        }
    </style>
</head>

<body>


    <br>
    <br>
    <div class="heading">
        <h1><b>{{ $eventList->name_event }}</b></h1>
        <p>Tanggal: {{ $eventList->date }}</p>
    </div>
    <div class="container ">
        <section class="show">
            <div class="show-image">
                <img src="{{ asset($eventList->event_image) }}" alt="Event Image">
            </div>
            <div class="show-content">
                <h2>📍{{ $eventList->location }}</h2>
                <p>{{ $eventList->description_event }}</p>
                <br>
                <br>
                <h6>interested in sponsoring? apply here!</h6>
                <h6>Events Rating! {{ $avgRating }}★ <a href="/rating/{{ $eventList->id }}/show" class="">Show
                        All
                        Rating</a></h6>
                @php
                    // dd(session('account')['id']);
                    $volunteer = App\Models\EventRegistModel::where('account_id', session('account')['id'])->first();
                    // dd($volunteer);
                @endphp
                @if (@$volunteer->reward)
                    <a href="{{ route('certificate.download') }}">sertificate is HERE!</a>
                @endif
                <hr>
                <button type="button" class="sponsor" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Sponsorship
                </button>
                <button type="button" class="sponsor2" data-bs-toggle="modal" data-bs-target="#create-rating">
                    Give Ratings
                </button>
                <a href="/dashboard" class="read-more">Back to Dashboard</a>
            </div>
        </section>

        <!-- Error handler -->
        {{-- Modal for Sponsorship --}}
        @if ($errors->sponsorship->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    myModal.show();
                });
            </script>
        @endif

        {{-- Modal for Rating --}}
        @if ($errors->rating->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var ratingModal = new bootstrap.Modal(document.getElementById('create-rating'));
                    ratingModal.show();
                });
            </script>
        @endif



        <!-- Sponsor -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header bg-custom-blue text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Form Sponsorship</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form name="formEventShow" id="formEventShow" action="{{ route('addsponsorship') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ session('account')['id'] }}" name="account_id"
                                id="account_id" readonly>
                            <input type="hidden" value="{{ $eventList->id }}" name="event_id" id="event_id" readonly>

                            <div class="mb-3">
                                <label for="name_sponsor" class="form-label">Nama Sponsor</label>
                                <input type="text"
                                    class="form-control @error('nama_sponsor', 'sponsorship') is-invalid @enderror"
                                    name="nama_sponsor" value="{{ old('nama_sponsor') }}"
                                    placeholder="Masukan Nama Sponsor Anda">
                                @error('nama_sponsor', 'sponsorship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="Contact" class="form-label">Contact</label>
                                <input type="text"
                                    class="form-control @error('contact', 'sponsorship') is-invalid @enderror"
                                    name="contact" value="{{ old('contact') }}">
                                @error('contact', 'sponsorship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload Logo</label>
                                <input type="file"
                                    class="form-control @error('image', 'sponsorship') is-invalid @enderror"
                                    name="image">
                                @error('image', 'sponsorship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Rating -->
        <div class="modal fade" id="create-rating" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-custom-blue text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Form Rating</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form name="formEventShow" id="formEventShow" action="/rating" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $eventList->id }}" name="event_id" readonly>
                            <div class="mb-3 row">
                                <label for="feedback" class="col-sm-4 col-form-label">Leave a review :</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control @error('feedback', 'rating') is-invalid @enderror" name="feedback" rows="3">{{ old('feedback') }}</textarea>
                                    @error('feedback', 'rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="star" value="5" />
                                <label for="star5" title="5 stars">★</label>
                                <input type="radio" id="star4" name="star" value="4" />
                                <label for="star4" title="4 stars">★</label>
                                <input type="radio" id="star3" name="star" value="3" />
                                <label for="star3" title="3 stars">★</label>
                                <input type="radio" id="star2" name="star" value="2" />
                                <label for="star2" title="2 stars">★</label>
                                <input type="radio" id="star1" name="star" value="1" />
                                <label for="star1" title="1 star">★</label>
                                @error('star', 'rating')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Rate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>
