@extends('layouts.main')
@section('content')
<br>
<br>
<br>
<h1><b>Rating Event ! </b></h1>
    <div class="mt-5 border p-2 rounded-1 bg-light border">
        <table id="example" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Star</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ratings as $item)
                    {{-- @php
                    $acc = App\Models\Account::where('id', $item->account_id)->first();
                    // dd($acc);
                @endphp --}}
                    <tr>
                        <td>{{ $item->account->name }}</td>
                        <td>{{ $item->feedback }}</td>
                        <td>{{ $item->star }}</td>
                        <td>
                            @if ($item->account_id == session('account')['id'])
                                <form method="POST" action="{{ route('rating.destroy', ['rating' => $item->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger ms-3">Hapus</button>

                                </form>
                            @else
                            <p>Ini Bukan Comment mu</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
