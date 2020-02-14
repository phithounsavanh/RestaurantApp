@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "category"])
        <div class="col-md-8">
                <i class="fas fa-plus"></i> Create a Category
              <hr>
            @include('management.inc.error')
             <form action="/management/category" method="POST">
                @csrf
                <div class="form-group">
                  <label for="categoryName">Category Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Category.... ">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
             </form>
        </div>
    </div>
</div>
@endsection
