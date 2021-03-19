@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-4">
        <form method="POST" action="{{ route('insertHostel')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h2>Add a new Hostel</h2>
                <input required name=" owner_id" type="hidden" class="form-control" value="{{Auth::user()->id}}">
                <input required value="{{old('hostel_name')}}" name="hostel_name" type="text" class="form-control" placeholder="Hostel Name">
                <label required for="ta">Description:</label>
                <textarea required name="description" class="form-control" id="ta" rows="3">{{old('description')}}</textarea>
                <input required value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address">
                <input required value="{{old('phone_number')}}" name=" phone_number" type="number" class="form-control" placeholder="Phone number">
                <label required for="contact_person">Contact Person</label>
                <input value="{{Auth::user()->name}}" name="contact_person" type="text" class="form-control" placeholder="Contact Person">
                <div class="dropdown">
                    <label for="hostelType">Accomodation For</label>
                    <select name="accomodation_for" class="form-control" id="hostelType">
                        <option {{old('accomodation_for') == "Girls" ? 'selected':''}} value="Girls">Girls</option>
                        <option {{old('accomodation_for') == "Boys" ? 'selected':''}} value="Boys">Boys</option>
                        <option {{old('accomodation_for') == "Girls & Boys" ? 'selected':''}} value="Girls & Boys">Girls & Boys</option>
                    </select>
                    <br>
                </div>
                <label for="images">Add Hostel Image(s)</label>
                <div class="custom-file">
                    <label class="custom-file-label" for="images">Choose Image File(s)</label>
                    <input id="images" type="file" name="images[]" id="images" multiple><br><br>
                </div>
                Add Available Rooms
                <table id="room_table">
                    <thead>
                        <tr>
                            <th>Room Type</th>
                            <th>Quantity</th>
                            <th>Unit Price (&#2344;&#2375;.&#2352;&#2369;.)</th>
                            <th>Description </th>
                            <th><button title="Add More Fieldset" type="button" class="btn btn-primary btn-circle" onclick="appendRoomFields()"><i class="fas fa-plus-circle"></i></button></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr id="tr">
                            <td>
                                <input required title="Select 'Room Type' From the dropdown or Type a new one" autocomplete="off" onchange="a()" placeholder="Select / Type New" list="room_type" name="room_type[]" onkeyup="this.setAttribute('value', this.value);">
                                <datalist id="room_type">
                                    @foreach($rooms as $room)
                                    <option data-value="{{$room->room_id}}">{{$room->type}}</option>
                                    @endforeach
                                </datalist>
                            </td>
                            <td><input required type="number" name="available_quantity[]" placeholder="Quantity" onkeyup="this.setAttribute('value', this.value);"></td>
                            <td><input required type="number" name="room_price[]" placeholder="Unit Price (&#2344;&#2375;.&#2352;&#2369;.)" onkeyup="this.setAttribute('value', this.value);"></td>
                            <td><input required type="text" name="room_description[]" placeholder="Description" onkeyup="this.setAttribute('value', this.value);"></td>
                        </tr>
                    </tbody>
                </table>
                <input class="btn btn-primary" type="submit" value="Add Hostel">
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
        rooms = "<input title='Select 'Room Type' From the dropdown or Type a new one' required list='room_type' name='room_type[]' placeholder='Select / Type New' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'> <datalist id='room_type'> @foreach($rooms as $room) <option value='{{$room->type}}'>{{$room->type}}</option> @endforeach </datalist>";
        qty = "<td><input required type='number' name='available_quantity[]' placeholder='Quantity' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'></td>";
        unit_price = "<td><input required type='number' name='room_price[]' placeholder='Unit Price (&#2344;&#2375;.&#2352;&#2369;.)' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'></td>";
        desc = "<td><input required type='text' name='room_description[]' placeholder='Description' onkeyup='this.setAttribute(&quot;value&quot;, this.value);'></td>";
        btn = "<td><button title = 'Remove This Fieldset' type='button' class='btn btn-danger btn-circle' onclick='removeRoomFields(this)'><i class='fas fa-minus-circle'></td>";

        rows = "<tr id='" + i + "'><td>" + rooms + qty + unit_price + desc+ btn + "</tr>";
        document.getElementById("tbody").innerHTML += rows;
    }

    function removeRoomFields(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("room_table").deleteRow(i);
    }
</script>
@endsection