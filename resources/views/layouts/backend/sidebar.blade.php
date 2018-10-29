<?php
use App\Http\Controllers\Controller as ct;
$rangePending = ct::rangeRentalCount("Pending");
$rangeAccepted = ct::rangeRentalCount("Accepted");

$totalMembers = ct::countTotalMembers();
$totalMembersRequest = ct::countMembersRequest();

$totalLessonRequest = ct::countLessonRequest();
$totalLessonEnrolled = ct::countLessonEnrolled();
 ?>

<div class="left main-sidebar">

  <div class="sidebar-inner leftscroll">

    <div id="sidebar-menu">

    <ul>

        <li class="submenu">
          <a class="{{ Request::is('admin/dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}"><i class="fa fa-fw fa-bars"></i><span> Dashboard </span> </a>
        </li>

        <li class="submenu">
            <a href="#" class="{{ Request::is('admin/news/add') || Request::is('admin/news/list') ? 'active' : '' }}"><i class="fa fa-fw fa-newspaper-o"></i> <span> News </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="{{  Request::is('admin/news/add') ? 'active' : ''}}"><a href="{{url('/admin/news/add')}}">Add News</a></li>
              <li class="{{  Request::is('admin/news/list') ? 'active' : ''}}"><a href="{{url('admin/news/list')}}">View News</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="#" class="{{ Request::is('admin/events/add') || Request::is('admin/events/list') ? 'active' : ''  }}"><i class="fa fa-fw fa-table"></i> <span> Events </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="{{ Request::is('admin/events/add') ? 'active' : '' }}"><a href="{{url('/admin/events/add')}}">Add Events</a></li>
              <li class="{{ Request::is('admin/events/list') ? 'active' : '' }}"><a href="{{url('admin/events/list')}}">View Events</a></li>
            </ul>
        </li>
<!-- 
        <li class="submenu">
          <a class="{{ Request::is('admin/refund') ? 'active' : ''}}" href="{{route('refund')}}"><i class="fa fa-fw fa-bars"></i><span> Refund </span> </a>
        </li> -->

        <li class="submenu">
            <a href="#" class="{{ Request::is('admin/range-rental/pending/list') || Request::is('admin/range-rental/accepted/list') ? 'active' : '' }}"><i class="fa fa-fw fa-arrow-circle-o-right"></i> <span> Range Rental </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="{{ Request::is('admin/range-rental/pending/list') ? 'active' : ''}}"><a href="{{url('/admin/range-rental/pending/list')}}">Pending List <span class="label radius-circle bg-danger float-right">{{ $rangePending }}</span></a></li>
              <li class="{{ Request::is('admin/range-rental/accepted/list') ? 'active' : ''}}"><a href="{{url('/admin/range-rental/accepted/list')}}">Accepted List <span class="label radius-circle bg-danger float-right">{{ $rangeAccepted }}</span></a></li>
              <li class="{{ Request::is('admin/range-rental/completed/list') ? 'active' : ''}}"><a href="{{url('/admin/range-rental/completed/list')}}">Completed List</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="#" class="{{ Request::is('admin/membership/list') || Request::is('admin/membership/request') ? 'active' : '' }}"><i class="fa fa-fw fa-user-circle"></i> <span> Membership </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="{{ Request::is('admin/membership/list') ? 'active' : '' }}"><a href="{{route('membership_list')}}">List <span class="label radius-circle bg-danger float-right">{{ $totalMembers }}</span></a></li>
              <li class="{{ Request::is('admin/membership/request') ? 'active' : '' }}"><a href="{{route('membership_request')}}">Request List <span class="label radius-circle bg-danger float-right">{{ $totalMembersRequest }}</span></a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="#" class="{{ Request::is('admin/lesson/list') || Request::is('admin/lesson/request') ? 'active' : '' }}"><i class="fa fa-fw fa-book"></i> <span> Lessons </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="{{ Request::is('admin/lesson/list') ? 'active' : '' }}"><a href="{{route('lesson_list')}}">List <span class="label radius-circle bg-danger float-right">{{ $totalLessonEnrolled }}</span></a></li>
              <li class="{{ Request::is('admin/lesson/request') ? 'active' : '' }}"><a href="{{route('lesson_request')}}">Request List <span class="label radius-circle bg-danger float-right">{{ $totalLessonRequest }}</span></a></li>
              <li class="{{ Request::is('admin/lesson/schedule-request') ? 'active' : '' }}"><a href="{{url('/admin/lesson/schedule-request')}}">Schedule Request </a></li>
              <li class="{{ Request::is('admin/lesson/schedule-request/accepted') ? 'active' : '' }}"><a href="{{url('/admin/lesson/schedule-request/accepted')}}">Session Schedule List </a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="#" class="{{ Request::is('admin/gallery/add') || Request::is('admin/gallery/list') ? 'active' : '' }}"><i class="fa fa-fw fa-image"></i> <span> Galleries </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="{{ Request::is('admin/gallery/add') ? 'active' : '' }}"><a href="{{url('/admin/gallery/add')}}">Add Image</a></li>
              <li class="{{ Request::is('admin/gallery/list') ? 'active' : '' }}"><a href="{{url('/admin/gallery/list')}}">Gallery List</a></li>
            </ul>
        </li>


    </div>

    <div class="clearfix"></div>

  </div>

</div>
