@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="row">
    <div class="col-md-12"> 
      @if($sales->count() > 0)

      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Main Functions</a></li>
          <li class="breadcrumb-item"><a href="/report">Report</a></li>
          <li class="breadcrumb-item active" aria-current="page">Result</li>
        </ol>
      </nav>

      <div class="alert alert-success" role="alert">
          <p> Amount From {{$dateStart}} To {{$dateEnd}} is ${{number_format($totalSale,2)}}
          </p>
          <p>
            Total Result: {{$sales->total()}}
          </p>
      </div>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12">
      <table class="table">
        <thead>
          <tr class="bg-primary text-light">
            <th scope="col">#</th>
            <th scope="col">Receipt ID</th>
            <th scope="col">Date Time</th>
            <th scope="col">Table</th>
            <th scope="col">Staff</th>
            <th scope="col">Total Amount</th>
         
          </tr>
        </thead>
        <tbody>
          
          @php
            $countSale = ($sales->currentPage() -1) * $sales->perPage() + 1; 
          @endphp
          @foreach($sales as $sale)
          <tr class="bg-primary text-light">
          <th  scope="row">{{$countSale++}}
            <td>{{$sale->id}}</td>
            <td>{{ date("m/d/Y H:i:s", strtotime($sale->updated_at))}}</td>
            <td>{{$sale->table_name}}</td>
            <td>{{$sale->user_name}}</td>
            <td>{{$sale->total_price}}</td>
          </th>
          </tr>
            <tr>
              <th></th>
              <th>Menu ID</th>
              <th>Menu</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total Price</th>
            </tr>
            @foreach($sale->saleDetails as $saleDetail)
            <tr>
              <td></td>
              <td>{{$saleDetail->menu_id}}</td>
              <td>{{$saleDetail->menu_name}}</td>
              <td>{{$saleDetail->quantity}}</td>
              <td>{{$saleDetail->menu_price}}</td>
              <td>{{$saleDetail->menu_price * $saleDetail->quantity}}</td>
            </tr>
            @endforeach
    
          @endforeach
        </tbody>
      </table>

      {{$sales->appends($_GET)->links()}}

      <form action="/report/show/export" method="get">
        <input type="hidden" name="dateStart" value="{{$dateStart}}" >
        <input type="hidden" name="dateEnd" value="{{$dateEnd}}" >
        <input class="btn btn-warning" type="submit" value="Export Excel">
      </form>

      @else 
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Main Functions</a></li>
          <li class="breadcrumb-item"><a href="/report">Report</a></li>
        </ol>
      </nav>
     
      <div class="alert alert-danger" role="alert">
        Sale Information is not found !
      </div>

      <a href="{{ URL::previous() }}" class="btn btn-warning">Back</a>

      @endif

    </div>
    </div>
</div>

@endsection
