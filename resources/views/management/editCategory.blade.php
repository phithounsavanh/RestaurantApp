@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "category"])
        <div class="col-md-8">
                <i class="fas fa-plus"></i> Edit a Category
              <hr>
            @include('management.inc.error')
             <form action="/management/category/{{$category->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="categoryName">Category Name</label>
                <input type="text" name="name" value="{{$category->name}}" class="form-control" placeholder="Category.... ">
                </div>
                <button type="submit" class="btn btn-warning">Update</button>
             </form>
        </div>
    </div>
</div>
@endsection
