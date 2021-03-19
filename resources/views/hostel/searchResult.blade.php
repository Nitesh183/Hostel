@extends('layouts.app')

@section('content')
<h2>Search Results</h2>
<h4>based on your given address</h4>

@if(count($hostels->get())>0)

<table class="table table-hover table-borderless table-responsive" style="border: black">
    <thead class="text-center align-middle text-white-50">
        <th>Image</th>
        <th>Owner</th>
        <th>Hostel Name</th>
        <th>Description</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Contact Person</th>
        <th>Accomodation for</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach($hostels->get() as $hostel)
        <tr onclick="window.location('{{route('viewHostel', $hostel->hostel_id)}}');" style="cursor:pointer;">
            <td class="text-center align-middle">
                @if($hostel->getImages()->count()!=0)
                <?php $h_ = '';
                foreach ($hostel->getImages()->get() as $h) {
                    $h_ = $h->filename;
                    break;
                } ?>
                <img onclick="window.location='{{route('viewHostel', $hostel->hostel_id)}}'" style="border-radius: 10%;cursor:pointer;" src="{{url('/images/hostels')}}/{{$h_}}">
                @else
                <span class="badge badge-pill bg-dark text-white-50">Image NA</span>
                @endif
            </td>
            <td class="text-center align-middle">{{$hostel->getOwner->name}}</td>
            <td class="text-center align-middle">{{$hostel->hostel_name}}</td>
            <td class="text-justify align-middle">{{Str::limit($hostel->description, 200)}}</td>
            <td class="text-center align-middle">{{$hostel->address}}</td>
            <td class="text-center align-middle">{{$hostel->phone_number}}</td>
            <td class="text-center align-middle">{{$hostel->contact_person}}</td>
            <td class="text-center align-middle">{{$hostel->accomodation_for}}</td>
            <td class="text-center align-middle">
                <a title="View Details" href="{{route('viewHostel', $hostel->hostel_id)}}"><i class="fas fa-align-justify"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection('content')