@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome!</h1>
    This is a hostel booking application.
    </p>
    <div class="search_container">
        <div class=search>
            <form class="form-inline" method="POST" action="{{route('findByAddress')}}">
                @csrf
                <input autofocus name="searchAddress" style="width: 275px;" class="fas form-control form-control-lg" type="search" placeholder="&#xf5a0; Locate Hostels by Address" aria-label="Search">
                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>
        <div style="text-align: center; margin-top:5px">
            <span class="font-italic text-muted" style="color:light-blue;">
                Example: 'Kathmandu' or 'Gyaneshwor'
            </span>
        </div>

    </div>
</div>
@endsection