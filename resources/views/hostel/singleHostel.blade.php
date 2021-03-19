@extends('layouts.app')
@section('content')

<div class="card bg-transparent w-50">
    <h2 class="m-auto">{{$hostel->hostel_name}}</h2>
    <hr>
    @if($hostel->getImages()->count()!=0)
    <div id="ci" class="carousel slide m-auto" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#ci" data-slide-to="0" class="active"></li>
            <li data-target="#ci" data-slide-to="1"></li>
            <li data-target="#ci" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <?php $h_ = '';
                foreach ($hostel->getImages()->get() as $h) {
                    $h_ = $h->filename;
                    break;
                } ?>
                <img class="d-block w-100" src="{{url('/images/hostels')}}/{{$h_}}" alt="First slide">
            </div>

            @foreach($hostel->getImages()->get() as $hostelImage)
            <div class="carousel-item" style="width:100%">
                <img class="d-block w-100" src="{{url('/images/hostels')}}/{{$hostelImage->filename}}">
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#ci" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#ci" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    @else
    <span class="badge badge-pill bg-dark text-white-50">Image NA</span>
    @endif
    <hr>
    <p class="desc text-justify">{{ $hostel->description }}</p>
    <hr>
    <div class="row">
        <div class="hostel_info m-auto">
            <p><i class="fas fa-user"> Owner: </i> <span class="badge badge-pill badge-info">{{ $hostel->getOwner->name }}</span></p>
            <p><i class="fas fa-envelope"> Owner Email: </i> <span class="badge badge-pill badge-info">{{ $hostel->getOwner->email }}</span></p>
            <p><i class="fas fa-map-pin"> Address</i> <span class="badge badge-pill badge-info">{{ $hostel->address }}</span></p>
            <p><i class="fas fa-phone-volume"></i> Phone <span class="badge badge-pill badge-info">{{ $hostel->phone_number }}</span></p>
            <p><i class="fas fa-address-card"></i> Contact Person <span class="badge badge-pill badge-secondary">{{ $hostel->contact_person }}</span></p>
            <p><i class="fas fa-venus-mars"></i> Accomodation For <span class="badge badge-pill badge-info">{{ $hostel->accomodation_for }}</span></p>
        </div>
        <div class="room_info m-auto">
            <p><i class="fas fa-bed"></i> Available Room Types <span class="badge badge-pill badge-info">{{ $hostel->room_type }}</span></p>
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Room Type</th>
                        <th>Quantity</th>
                        <th>Unit Price (&#2344;&#2375;.&#2352;&#2369;.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hostel->getRooms()->get() as $room)
                    <tr>
                        <td class="text-center align-middle">{{$room->type}}</td>
                        <td class="text-center align-middle">{{$room->pivot->room_price}}</td>
                        <td class="text-center align-middle">{{$room->pivot->available_quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--Book Hostel Modal -->
        <button class="btn btn-warning" data-toggle="modal" data-target="#htl_{{$hostel->id}}" style="cursor: pointer; width:20%;">Request Booking</button>
        <div class="modal fade" id="htl_{{$hostel->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <p class="modal-title"> Please submit this form to send a booking request for "{{ $hostel->hostel_name }}. We will get back to you once we recieve your request.</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-auto">
                        <form method="POST" action="{{ route('requestBooking')}}">
                            @csrf
                            <input type="hidden" name="owner_id" value="{{$hostel->owner_id}}">
                            <input type="hidden" name="hostel_id" value="{{$hostel->hostel_id}}">
                            <input autofocus required value="{{old('requestor_name')}}" name="requestor_name" type="text" class="form-control" placeholder="Your Name"><br>
                            <input required value="{{old('requestor_address')}}" name="requestor_address" type="text" class="form-control" placeholder="Your Address"><br>
                            <input required value="{{old('requestor_phone')}}" name="requestor_phone" type="text" class="form-control" placeholder="Your Phone Number"><br>
                            @foreach($hostel->getRooms()->get() as $room)
                            <input type="checkbox" name="booked_room[]" value="{{$room->type}}"> {{$room->type}}
                            @endforeach
                            <br>
                            <input class="btn btn-primary" type="submit" value="Send Booking Request">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection