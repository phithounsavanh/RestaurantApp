@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "user"])
        <div class="col-md-8">
            <i class="fas fa-users"></i> User
            <a href="/management/user/create" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create User</a>
            <hr>
            {{-- Display Status --}}
            @if(Session()->has('status'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">x</button>
              {{ Session()->get('status') }} &#x1F600;
            </div>
            @endif

            <table class="table table-bordered">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Email</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->role}}</td>
                    <td><span class="badge {{$user->status == 1 ? 'badge-success' : 'badge-danger'}}">{{$user->status == 1 ? 'Activate' : 'Deactivate'}}</span></td>
                    <td>{{$user->email}}</td>
                    <td><a href="/management/user/{{$user->id}}/edit" class="btn btn-warning">Edit</a></td>
                    <td>
                      <form action="/management/user/{{$user->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{$users->links()}}
              
              
      
        </div>
    </div>
</div>
@endsection
