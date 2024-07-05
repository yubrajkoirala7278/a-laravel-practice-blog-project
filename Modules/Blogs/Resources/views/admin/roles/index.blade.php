@extends('blogs::admin.layouts.master')

@section('page-name')
    Roles
@endsection

@section('content')
    <div class="container bg-white p-4">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-bold fs-5 text-success">Roles</h2>
            <a href="{{route('roles.create')}}" class="btn btn-success">Add Roles</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key=>$role)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <a href="{{route('add.permissions.to.role',$role->id)}}" class="btn btn-success">Add/Edit Permission</a>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
@endsection
