@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-4">
        <form method="POST" action="{{ route('updateHostel', $hostel->hostel_id)}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h2>Update Hostel details</h2>
                <input name="owner_id" type="hidden" class="form-control" value="{{Auth::user()->id}}">
                <input value="{{$hostel->hostel_name}}" name="hostel_name" type="text" class="form-control" placeholder="Hostel Name"><br>
                <label for="ta">Description:</label>
                <textarea name="description" class="form-control" id="ta" rows="3">{{$hostel->description}}</textarea>
                <input value="{{$hostel->address}}" name="address" type="text" class="form-control" placeholder="Address">
                <input value="{{$hostel->phone_number}}" name="phone_number" type="number" class="form-control" placeholder="Phone number">
                <input value="{{$hostel->contact_person}}" name="contact_person" value="{{Auth::user()->name}}" type="text" class="form-control" placeholder="Contact Person">
                <div class="dropdown"><br>
                    <label for="hostelType">Accomodation For</label>
                    <select name="accomodation_for" class="form-control" id="hostelType">
                        <option {{old('accomodation_for', $hostel->accomodation_for)=="Girls"? 'selected':''}} value="Boys">Girls</option>
                        <option {{old('accomodation_for', $hostel->accomodation_for)=="Boys"? 'selected':''}} value="Boys">Boys</option>
                        <option {{old('accomodation_for', $hostel->accomodation_for)=="Girls & Boys"? 'selected':''}} value="Girls & Boys">Girls & Boys</option>
                    </select>
                    <br>
                </div>
                <label for="">View & Delete existing Images</label>
                <div class="border border-secondary rounded p-2" style="width:100%">
                    @foreach($hostel->getImages()->get() as $hostelImage)
                    <img class="rounded-lg link" data-toggle="modal" data-target="#img_{{$hostelImage->id}}" style="cursor: pointer; width:20%;" src="{{url('/images/hostels')}}/{{$hostelImage->filename}}">
                    @endforeach
                </div>
                @foreach($hostel->getImages()->get() as $hostelImage)
                <!--Image Full-size view Modal -->
                <div class="modal fade" id="img_{{$hostelImage->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content bg-transparent">
                            <div class="modal-body m-auto">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <img class="" src="{{url('/images/hostels')}}/{{$hostelImage->filename}}">
                                <div class="modal-footer">
                                    <a class="btn btn-danger m-auto" href="#"><i class="fas fa-minus-circle"></i>&nbsp;Delete Image</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <br>
                <label class="d-block" for="images">Add New Hostel Image(s)</label>
                <div class="custom-file">
                    <label class="custom-file-label" for="images">Choose Image File(s)</label>
                    <input id="images" type="file" name="images[]" id="images" multiple><br>
                </div>
                <br>
                <table id="room_table"><br>
                    <label for="">Add Available Rooms</label>
                    <thead>
                        <tr>
                            <th>Room Type</th>
                            <th>Quantity</th>
                            <th>Unit Price (&#2344;&#2375;.&#2352;&#2369;.)</th>
                            <th>Description</th>
                            <th><button title="Add More Fieldset" type="button" class="btn btn-primary btn-circle" onclick="appendRoomFields()"><i class="fas fa-plus-circle"></i></button></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($hostel->getRooms()->get() as $room)
                        <tr id="tr">
                            <input type="hidden" name="r_ids[]" value="{{$room->room_id}}">
                            <td>
                                <input value="{{$room->type}}" required title="Select 'Room Type' From the dropdown or Type a new one" autocomplete="off" placeholder="Select / Type New" list="room_type" name="room_type[]" onkeyup="this.setAttribute('value', this.value);">
                                <datalist id="room_type">
                                    @foreach($hostel->getRooms()->get() as $room_)
                                    <option data-value="{{$room->room_id}}">{{$room_->type}}</option>
                                    @endforeach
                                </datalist>
                            </td>
                            <td><input value="{{$room->pivot->available_quantity}}" type=" number" name="available_quantity[]" placeholder="Quantity" onkeyup="this.setAttribute('value', this.value);"></td>
                            <td><input value="{{$room->pivot->room_price}}" type=" number" name="room_price[]" placeholder="Unit Price" onkeyup="this.setAttribute('value', this.value);"></td>
                            <td><input value="{{$room->description}}" required type="text" name="room_description[]" placeholder="Description" onkeyup="this.setAttribute('value', this.value);"></td>
                            <td><button title='Remove This Fieldset' type='button' class='btn btn-danger btn-circle' onclick='removeRoomFields(this)'><i class='fas fa-minus-circle'></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <input class="btn btn-primary" type="submit" value="Update Hostel">
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function appendRoomFields() {
        if (typeof i === "undefined" || i === null) {
            i = 1;
            rows = '';

        } else {
            i++;
        }
        rooms = "<input title='Select 'Room Type' From the dropdown or Type a new one' required list='room_type' name='room_type[]' placeholder='Select / Type New' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'> <datalist id='room_type'> @foreach($errors ?? '' as $room) <option value='{{$room->type}}'>{{$room->type}}</option> @endforeach </datalist>";
        qty = "<td><input required type='number' name='available_quantity[]' placeholder='Quantity' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'></td>";
        unit_price = "<td><input required type='number' name='room_price[]' placeholder='Unit Price (&#2344;&#2375;.&#2352;&#2369;.)' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'></td>";
        desc = "<td><input required type='text' name='room_description[]' placeholder='Description' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'></td>";
        btn = "<td><button title = 'Remove This Fieldset' type='button' class='btn btn-danger btn-circle' onclick='removeRoomFields(this)'><i class='fas fa-minus-circle'></td>";

        rows = "<tr id='" + i + "'><td>" + rooms + qty + unit_price + desc + btn + "</tr>";
        document.getElementById("tbody").innerHTML += rows;
    }

    function removeRoomFields(r) {
        return false;
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("room_table").deleteRow(i);
    }
</script>
@endsection