@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h3>Service</h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 text-center mainfunction-item">
                            <a href="/service/cashier">
                                <h4>Cashier</h4>
                                <img src="{{asset('images/cashier.svg')}}" width="50px" alt="">
                            </a>
                        </div>
                        <div class="col-sm-6 text-center mainfunction-item">
                          <a href="/cahsier">
                              <h4>Kitchen</h4>
                              <img src="{{asset('images/kitchen.svg')}}" width="50px" alt="">
                          </a>
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
