@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2>List of Booking Requests</h2>
        <table class="table table-hover table-borderless table-responsive" style="border: black">
            <thead class="text-center align-middle text-white-50">
                <tr>
                <th>Hostel ID </th>
                    <th>Booked Rooms</th>
                    <th>Booked by</th>
                    <th>Booker's Address</th>
                    <th>Booker's Phone</th>
                    <th></th>
                </tr>
            </thead>
            @for ($i = 0; $i < count($bookings); $i++)
            <tr>
                <td>{{$bookings[$i]->hostel_id}}</td>
                <td>{{$bookings[$i]->room_id}}</td>
                <td>{{$bookings[$i]->requestor_name}}</td>
                <td>{{$bookings[$i]->requestor_address}}</td>
                <td>{{$bookings[$i]->requestor_phone}}</td>
            </tr>
           @endfor
        </table>
    </div>
</div>
@endsection