@extends('blogs::admin.layouts.master')

@section('page-name')
    Dashboard
@endsection

@section('content')
    <div class="container bg-white p-4">
        <form action="{{route('roles.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="role" name="name">
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
