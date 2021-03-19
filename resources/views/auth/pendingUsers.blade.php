@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2>List of Pending Registration Requests</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>User name</th>
                    <th>Email</th>
                    <th>Registered at</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            @forelse ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td><a href="{{ route('approvePendingUser', $user->id) }}" class="btn btn-primary btn-sm">Approve</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No users found.</td>
            </tr>
            @endforelse
        </table>
    </div>
</div>
@endsection