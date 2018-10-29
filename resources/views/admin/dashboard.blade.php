@extends('layouts.backend.master')
@section('content')
<?php
use App\Http\Controllers\Controller as ct;
$rangePending = ct::rangeRentalCount("Pending");
$rangeAccepted = ct::rangeRentalCount("Accepted");
$totalCount = ct::rangeRentalTotalCount();

$totalMembers = ct::countTotalMembers();
$totalMembersRequest = ct::countMembersRequest();
 ?>

						<div class="row">
									<div class="col-xl-12">
											<div class="breadcrumb-holder">
													<h1 class="main-title float-left">Dashboard</h1>
													<ol class="breadcrumb float-right">
														<li class="breadcrumb-item">Home</li>
														<li class="breadcrumb-item active">Dashboard</li>
													</ol>
													<div class="clearfix"></div>
											</div>
									</div>
						</div>
						<!-- end row -->


							<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-success">
												<a href="{{url('admin/range-rental/pending/list')}}">
													<i class="fa fa-file-text-o float-right text-white"></i>
													<h6 class="text-white text-uppercase m-b-20">Range Rental</h6>
													<h1 class="m-b-20 text-white counter">{{$totalCount}}</h1>
													<span class="text-white">{{$rangePending}} Pending Request</span>
													</a>
											</div>
									</div>



									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-info">
                        <a href="{{url('/admin/membership/request')}}">
  													<i class="fa fa-user-o float-right text-white"></i>
  													<h6 class="text-white text-uppercase m-b-20">Members</h6>
  													<h1 class="m-b-20 text-white counter">{{$totalMembers}}</h1>
  													<span class="text-white">{{$totalMembers}} Pending Request</span>
                          </a>
											</div>
									</div>

									<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
											<div class="card-box noradius noborder bg-danger">
													<i class="fa fa-bell-o float-right text-white"></i>
													<h6 class="text-white text-uppercase m-b-20">Alerts</h6>
													<h1 class="m-b-20 text-white counter">58</h1>
													<span class="text-white">5 New Alerts</span>
											</div>
									</div>
							</div>



@endsection
