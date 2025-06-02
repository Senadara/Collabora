@extends('layouts.main')
@section('content')
<br>
<br>
<br>
<div class="d-flex align-items-center">
  <h1 class="mb-0">Manage Sponsor List</h1>
    </div>
    <div class=" mt-5 border p-2 rounded-1 bg-light border">
        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-dark" href="/partner">sponsor</a>
        </div>
        <table id="example" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nama sponsor</th>
                    <th>Contact</th>
                    <th>Logo</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sponsorList as $item)
                {{-- @php
                    $acc = App\Models\Account::where('id', $item->account_id)->first();
                    // dd($acc);
                @endphp --}}
                @if($item->status == 'request')
                    <tr>
                        <td>{{ $item->nama_sponsor }}</td>
                        <td>{{ $item->contact }}</td>
                        <td>{{ $item->img }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a class="btn btn-danger btn-sm"href="{{ route('deny.sponsor', ['id' => $item->id]) }}">deny</a>
                            <a class="btn btn-success btn-sm"href="{{ route('accept.sponsor', ['id' => $item->id]) }}">accept</a>
                        </td>
                    </tr>
                 @endif   
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
