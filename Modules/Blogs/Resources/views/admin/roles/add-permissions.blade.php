@extends('blogs::admin.layouts.master')

@section('page-name')
    Dashboard
@endsection

@section('content')
    <div class="container bg-white p-4">
        <h2 class="fw-semibold fs-4 text-success">Role: {{ $role->name }}</h2>
        <hr>
        <h3 class="fw-semibold fs-5 text-primary">Permissions</h3>
        <form action="{{route('give.permission.to.role',$role->id)}}" method="POST">
            @csrf
            <div class="d-flex align-items-center" style="gap: 13px;flex-wrap:wrap">
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$permission->name}}" id="{{ $permission->name }}"
                            @checked(in_array($permission->id, $rolePermissions)) name="permission[]" >
                        <label class="form-check-label" for="{{ $permission->name }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-success" type="submit">Submit</button>
        </form>
    </div>
@endsection
