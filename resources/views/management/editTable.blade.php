@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @include('management.inc.sidebar', ["menu" => "table"])
        <div class="col-md-8">
                <i class="fas fa-plus"></i> Edit a Table
              <hr>
            @include('management.inc.error')
             <form action="/management/table/{{$table->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="TableName">Table Name</label>
                <input type="text" name="name" value="{{$table->name}}" class="form-control" placeholder="Table.... ">
                </div>
                <button type="submit" class="btn btn-warning">Update</button>
             </form>
        </div>
    </div>
</div>
@endsection
