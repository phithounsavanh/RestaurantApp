@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h3>Main Functions</h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        @if(Auth::user()->checkAdmin())
                        <div class="col-sm-4 text-center mainfunction-item">
                            <a href="/management">
                                <h4>Managment</h4>
                                <img src="{{asset('images/management.svg')}}" width="50px" alt="">
                            </a>
                        </div>
                        <div class="col-sm-4 text-center mainfunction-item">
                            <a href="/report">
                                <h4>Report</h4>
                                <img src="{{asset('images/report.svg')}}" width="50px" alt="">
                            </a>
                        </div>
                        @endif
                        <div class="col-sm-4 text-center mainfunction-item">
                            <a href="/service/cashier">
                                <h4>Cashier</h4>
                                <img src="{{asset('images/cashier.svg')}}" width="50px" alt="">
                            </a>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
