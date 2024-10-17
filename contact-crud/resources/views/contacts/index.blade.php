@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Contact List</h1>

    <!-- Form Pencarian -->
    <form class="d-flex mb-4" action="{{ route('contacts.index') }}" method="GET">
        <input class="form-control me-2" type="search" name="search" value="{{ $search }}" placeholder="Search contacts...">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->address }}</td>
                    <td>
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('contacts.create') }}" class="btn btn-primary">Create New Contact</a>
</div>
@endsection
