@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "menu"])
        <div class="col-md-8">
          
                <i class="fas fa-hamburger"></i> Menu
                <a href="/management/menu/create" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create a Menu</a>
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
                    <th scope="col">Menu</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($menus as $menu)
                  <tr>
                    <th scope="row">{{$menu->id}}</th>
                    <td>{{$menu->name}}</td>
                    <td>
                        <img width="120px" height="120px" src="{{asset('menu_images')}}/{{$menu->image}}" alt="{{$menu->name}}" class="img-thumbnail" style="border:none">
                    </td>
                    <td>{{$menu->price}}</td>
                    <td>{{$menu->description}}</td>
                    <td>{{$menu->category->name}}</td>
                    <td><a href="/management/menu/{{$menu->id}}/edit" class="btn btn-warning">Edit</a></td>
                    <td>
                      <form action="/management/menu/{{$menu->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{$menus->links()}}
      
        </div>
    </div>
</div>
@endsection
