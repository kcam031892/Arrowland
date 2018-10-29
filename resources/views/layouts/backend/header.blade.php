<div class="headerbar">

  <!-- LOGO -->
      <div class="headerbar-left">
    <a href="{{route('dashboard')}}" class="logo"><img alt="Logo" src="{{ asset('images/backend/logo2.png') }}" /> <span>Arrowland</span></a>
      </div>

      <nav class="navbar-custom">

                  <ul class="list-inline float-right mb-0">



          <li class="list-inline-item dropdown notif">
                          <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                              <i class="fa fa-fw fa-bell-o"></i><span class="noti-red"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg">
              <!-- item-->
                              <div class="dropdown-item noti-title">
                                  <h5><small><span class="label label-danger pull-xs-right notification-count"></span>Notification</small></h5>
                              </div>

                              <div class="notifcation-body">

                              </div>



                              <!-- All-->
                              <a href="{{url('/admin/notification/list')}}" class="dropdown-item notify-item notify-all">
                                  View All
                              </a>

                          </div>
                      </li>

                      <li class="list-inline-item dropdown notif">
                          <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                              <img src="{{ asset('images/backend/user/'.Auth::user()->image)}}" alt="Profile image" class="avatar-rounded">
                          </a>
                          <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                              <!-- item-->
                              <div class="dropdown-item noti-title">
                                  <h5 class="text-overflow"><small>Hello, {{Auth::user()->name}}</small> </h5>
                              </div>

                              <!-- item-->
                              <a href="{{route('profile')}}" class="dropdown-item notify-item">
                                  <i class="fa fa-user"></i> <span>Profile</span>
                              </a>

                              <!-- item-->
                              <a href="{{route('logout')}}" class="dropdown-item notify-item">
                                  <i class="fa fa-power-off"></i> <span>Logout</span>
                              </a>

              <!-- item-->

                          </div>
                      </li>

                  </ul>

                  <ul class="list-inline menu-left mb-0">
                      <li class="float-left">
                          <button class="button-menu-mobile open-left">
                              <i class="fa fa-fw fa-bars"></i>
                          </button>
                      </li>
                  </ul>

      </nav>

</div>
