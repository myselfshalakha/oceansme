@extends('layouts.app')

@section('content')

    <div class="row dash-board-count-box">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Companies</h6>
                    <h2 class="text-right"><i class="fa fa-building f-left"></i><span>{{$companies}}</span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Events</h6>
                    <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span>{{$events}}</span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Event Admins</h6>
                    <h2 class="text-right"><i class="fa fa-user-secret f-left"></i><span>{{$event_admins}}</span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Evaluator</h6>
                    <h2 class="text-right"><i class="fa fa-user f-left"></i><span>{{$evaluators}}</span></h2>
                </div>
            </div>
        </div>
	</div>

      
@endsection
