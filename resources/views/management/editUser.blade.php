@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "user"])
        <div class="col-md-8">
                <i class="fas fa-user"></i> Edit a User
              <hr>
            @include('management.inc.error')
                <form action="/management/user/{{$user->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="Name">Name</label>
                  <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Name.... ">
                </div>
                <div class="form-group">
                  <label for="Email">Email</label>
                  <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Email.... ">
                </div>
                <div class="form-group">
                  <label for="Password">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password.... ">
                </div>
                <div class="form-group">
                  <label for="Role">Role</label>
                  <select name="role" class="form-control">
                    <option value="admin" {{$user->role == 'admin' ? 'selected':''}}>Admin</option>
                    <option value="staff" {{$user->role == 'staff' ? 'selected':''}}>Staff</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="Status">Status</label>
                  <select name="status" class="form-control">
                    <option value="1" {{$user->status == '1' ? 'selected':''}}>Activate</option>
                    <option value="0" {{$user->status == '0' ? 'selected':''}}>Deactivate</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
             </form>
        </div>
    </div>
</div>
@endsection
