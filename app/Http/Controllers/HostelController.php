<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hostel;
use App\HostelImage;
use App\User;
use App\Room;
use App\Booking;
use Image;
use Session;
use Auth;
use DB;

class HostelController extends Controller
{

    public function index()
    {
        $data = [];
        $data['requests_count'] = (User::whereNull('approved_at')->get())->count();
        return view('index', $data);
    }

    public function newHostel()
    {
        $q = 'SELECT * FROM room AS r, hostel_room AS hr, hostel AS h ';
        $data = [];
        $data['rooms'] = DB::select(DB::raw($q . 'WHERE r.room_id = hr.room_id AND hr.hostel_id = h.hostel_id AND h.owner_id =' . Auth::user()->id) . ' GROUP BY r.description');
        return view('hostel.newHostel', $data);
    }

    public function listHostel()
    {
        $user = Auth::user();
        $hostels = $user->getHostels()->get();
        return view('hostel.hostelList', compact('hostels'));
    }

    public function insertHostel(Request $request)
    {
        if ($request->isMethod('Post')) {

            /* Form data/model Validation  */
            $validatedData = $request->validate([
                'hostel_name' => 'required|string|max:100',
                'phone_number' => 'required|regex:/^[0-9]/',
                'description' => 'required|string|max:1000',
                'address' => 'required|string|max:1000',
                'contact_person' => 'required|string|max:50',
                'accomodation_for' => 'required|string|max:50',
                'room_type' => 'required|max:50'
            ]);

            $data = $request->all(); /* Maps each form element name to table columns for insertion. */

            /* Skip room details for later insertion */
            $data = $request->except('room_type');
            $data = $request->except('room_description');
            $data = $request->except('available_quantity');
            $data = $request->except('price');
            $data = $request->except('images'); /* Skip image attribute for later. */

            $hostel = Hostel::create($data);  /*Saving details in Hostel's table columns.*/

            /* Insert to Room's table */
            $room = null;
            $i = 0;
            while ($i < count($request->get('room_type'))) {
                $room = Room::where('type', $request->get('room_type')[$i])->first();
                if ($room == null) { /* If user input type is not found in DB, prepare new entry & insert it. */
                    $room_new = new Room;
                    $room_new->type = $request->get('room_type')[$i];
                    $room_new->description = $request->get('room_description')[$i];
                    $room_new->save();
                    /* Insert to Pivot Table with extra fields. */
                    $hostel->getRooms()->attach($room_new->room_id, [
                        'room_price' => $request->room_price[$i],
                        'available_quantity' => $request->available_quantity[$i]
                    ]);
                } else {
                    $hostel->getRooms()->attach($room->room_id, [
                        'room_price' => $request->room_price[$i],
                        'available_quantity' => $request->available_quantity[$i]
                    ]);
                }
                $i++;
            }

            if ($request->hasFile('images')) {
                /* Validating image filetypes */
                $this->validate($request, ['images' => 'required', 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
                $images = $request->file('images');
                foreach ($images as $image) { /* Repeat action for each image in the bulk-upload */
                    /* Generating unique file name for each image uploads */
                    $fileName = rand(111, 99999) . time() . '.' . $image->getClientOriginalExtension();
                    $path = public_path() . '/images/hostels/' . $fileName;

                    $hostelImage = new HostelImage;
                    $hostelImage->filename = $fileName;
                    $hostelImage->hostel_id = $hostel->hostel_id;
                    /* Saving remaining attributes i.e. on images in the child table. 
                        Images' attributes are stored in hostel_images table which is the child of 'hostel'.
                        They are related with a foreign key */
                    $hostelImage->save();

                    /* Resizing image by fixed width and auto-height based on aspect ratio. */
                    $imgSave = Image::make($image)->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imgSave->save($path);/* Saving uploaded image to server's disk storage. */
                }
            }
            Session::flash('status', 'Successfully inserted hostel! ' . $hostel->name);
        }
        return redirect()->route('newHostel');
    }

    public function viewHostel($id)
    {
        $hostel = Hostel::find($id);
        return view('hostel.singleHostel', compact('hostel'));
    }

    public function deleteHostel($id, Request $request)
    {
        Hostel::destroy($id);
        Session::flash('status', 'Deleted Hostel Sucessfully!');
        return redirect()->route('listHostel');
    }

    public function updateHostel($id, Request $request)
    {
        Hostel::find($id);
        $hostel = Hostel::find($id);

        if ($request->isMethod('Post')) {
            $data = $request->all(); /* Maps each form element name to table columns for insertion. */

            /* Skip non-hostel-table details for later insertion */
            $data = $request->except('room_type');
            $data = $request->except('room_description');
            $data = $request->except('available_quantity');
            $data = $request->except('price');
            $data = $request->except('r_ids');
            $data = $request->except('images');

            /* Update Pivot Table */
            $j = 0;
            while ($j < count($request->get('room_type'))) {
                if (!empty($request->r_ids[$j])) {/* User has not added new room */
                    $hostel->getRooms()->updateExistingPivot($request->r_ids[$j], [
                        'available_quantity' => $request->available_quantity[$j],
                        'room_price' => $request->room_price[$j]
                    ]);
                    /* Update Many-side table - room */
                    $room_new = Room::find($request->r_ids[$j]);
                    $room_new->type = $request->get('room_type')[$j];
                    $room_new->description = $request->get('room_description')[$j];
                    $room_new->update(compact('room_new'));
                } else {/* User has added new room */
                    $room_new = new Room;
                    $room_new->type = $request->get('room_type')[$j];
                    $room_new->description = $request->get('room_description')[$j];
                    $room_new->save();
                    /* Insert to Pivot Table with extra fields. */
                    $hostel->getRooms()->attach($room_new->room_id, [
                        'room_price' => $request->room_price[$j],
                        'available_quantity' => $request->available_quantity[$j]
                    ]);
                }
                $j++;
            }
            $hostel->update($data);
            Session::flash('status', 'Sucessfully update hostel details!');
        }
        return view('hostel.updateHostel', compact('hostel'));
    }

    public function findByAddress(Request $request)
    {
        if ($request->isMethod('Post')) {
            $validatedData = $request->validate(['searchAddress' => 'required|string|max:1000',]);
            // Wildcard search of hostel details based on address attribute
            $hostels = Hostel::where('address', 'LIKE', '%' . $request->searchAddress . '%');
            if (count($hostels->get()) > 0) {
                Session::forget('status');
            } else {
                Session::flash('status', 'No result was found based on your given address!');
            }

            return view('hostel.searchResult', compact('hostels'));
        }
    }

    public function requestBooking(Request $request)
    {
        $i = 0;
        $data = [];
        $rooms = "";
        while ($i < count($request->get('booked_room'))) {
            $rooms = $rooms . "," . $request->get('booked_room')[$i];
            $i++;
        }
        $data['owner_id'] = $request->get('owner_id');
        $data['room_id'] = $rooms;
        $data['hostel_id'] = $request->get('hostel_id');
        $data['requestor_name'] = $request->get('requestor_name');
        $data['requestor_address'] = $request->get('requestor_address');
        $data['requestor_phone'] = $request->get('requestor_phone');
        Booking::create($data);

        Session::flash('status', 'Booking Request sent succesfully!');
        return redirect()->route('index');
    }

    public function getBookingRequests()
    {
        $data = [];
        $data['bookings'] = Booking::where('owner_id', '=', Auth::user()->id)->get();
        $data['booking_requests_count'] = Booking::where('owner_id', Auth::user()->id)->count();     
        return view('hostel.bookingRequests', $data);
    }
}
