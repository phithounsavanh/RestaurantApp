@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "menu"])
        <div class="col-md-8">
                <i class="fas fa-hamburger"></i> Edit a Menu
              <hr>
            @include('management.inc.error')
            <form action="/management/menu/{{$menu->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="menuName">Name</label>
                <input type="text" value="{{$menu->name}}" name="name" class="form-control" placeholder="Menu.... ">
                </div>

                <div class="form-group">
                  <label for="menuPrice">Price</label>
                <input type="text" value="{{$menu->price}}" name="price" class="form-control" placeholder="Menu.... ">
                </div>

                <label for="imageName">Image</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Upload</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="Description">Description</label>
                <input type="text" name="description" value="{{$menu->description}}" class="form-control" placeholder="Description ...">
                </div>

                <div class="form-group">
                  <label for="Description">Category</label>
                  <select class="form-control" name="category_id">
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{ $menu->category_id === $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
             </form>
        </div>
    </div>
</div>
@endsection
