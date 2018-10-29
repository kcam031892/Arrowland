@extends('layouts.backend.master')

@section('content')

<div class="row">
      <div class="col-xl-12">
          <div class="breadcrumb-holder">
              <h1 class="main-title float-left">Notifications</h1>
              <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Notifications</li>
              </ol>
              <div class="clearfix"></div>
          </div>
      </div>
</div>

<div class="row">
  <div class="col-md-12">


    @foreach($message as $data)
      @foreach($data as $arr)


      @if($arr['notificationable_type'] == "Reservation")
      @php
      $url = '/admin/range-rental/'.$arr['id'].'/detail';

      @endphp

      @else
      @php
      $url = '/admin/payment/'.$arr['id'].'/detail';

      @endphp

      @endif

      @if($arr['status'] == "Unread")

          <a href="{{ url($url) }}" class="dropdown-item notify-item btn-primary mt-2"><p class="notify-details"><b></b><span>{{$arr['message']}}</span></p><p>
            <small class="text-muted">{{$arr['time']}}</small>
          </p></a>
          <hr>

      @else


          <a href="{{ url($url) }}" class="dropdown-item notify-item mt-2"><p class="notify-details"><b></b><span>{{$arr['message']}}</span></p><p>
            <small class="text-muted">{{$arr['time']}}</small>
          </p></a>
          <hr>


      @endif




      @endforeach






    @endforeach

    {{$notification->links()}}


  </div>

</div>

@endsection()
