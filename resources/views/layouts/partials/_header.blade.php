

<!--===========header start===========-->
<header class="app-header navbar">

    <!--brand start-->
    <div class="navbar-brand">
        <a class="" href="{{ url('/meetings') }}">
            <img src="{{asset('assets/img/gta-logo.png')}}" alt="" height="45px" width="103px">
        </a>
    </div>
    <!--brand end-->

    <!--left side nav toggle start-->
    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item d-lg-none">
            <button class="navbar-toggler mobile-leftside-toggler" type="button"><i class="ti-align-right"></i></button>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link navbar-toggler left-sidebar-toggler" href="#"><i class=" ti-align-right"></i></a>
        </li>
        <li class="nav-item d-md-down-none-">
            <!--search start-->
            {{-- <a class="nav-link search-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="ti-search"></i>
            </a> --}}
            <div class="search-container">
                <div class="outer-close search-toggle">
                    <a class="close"><span></span></a>
                </div>

                {{-- <div class="container search-wrap">
                    <div class="row">
                        <div class="col text-left">
                            <a class="" href="#">
                                <img src="assets/img/logo.png" srcset="assets/img/logo@2x.png 2x" alt="">
                            </a>
                            <form class="mt-3">
                                <div class="form-row align-items-center">
                                    <input type="text" class="form-control custom-search"  placeholder="Search">
                                </div>
                            </form>

                            <div class="search-list">
                                <h5 class="text-white mb-4">Search Results</h5>
                                <ul class="list-unstyled ">
                                    <li>
                                        <a href="#" class="text-white">
                                            <span class="bg-danger">
                                                S
                                            </span>
                                            Simply dummy text of the printing
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-white">
                                            <span class="bg-success">
                                                C
                                            </span>
                                            Contrary Ipsum is not simply random text
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-white">
                                            <span class="bg-info">
                                                <i class="icon-basket-loaded "></i>
                                            </span>
                                            Ipsum has been industry's standard dummy
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!--search end-->
        </li>
    </ul>
    <!--left side nav toggle end-->

    <!--right side nav start-->
    <ul class="nav navbar-nav ml-auto">


        {{-- <li class="nav-item dropdown dropdown-slide d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="ti-bell"></i>
                <span class="badge badge-danger notification-alarm"> </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-header pb-3">
                    <strong>You have 6 Notifications</strong>
                </div>

                <a href="#" class="dropdown-item">
                    <i class="icon-basket-loaded text-primary"></i> New order
                </a>
                <a href="#" class="dropdown-item">
                    <i class="icon-user-follow text-success"></i> New registered member
                </a>
                <a href="#" class="dropdown-item">
                    <i class=" icon-layers text-danger"></i> Server error report
                </a>
                <a href="#" class="dropdown-item">
                    <i class=" icon-note text-warning"></i> Database report
                </a>

                <a href="#" class="dropdown-item">
                    <i class=" icon-present text-info"></i> Order confirmation
                </a>

            </div>
        </li> --}}
        {{-- <li class="nav-item dropdown dropdown-slide d-md-down-none">
            <a class="nav-link nav-pill" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class=" ti-view-grid"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-ql-gird">

                <div class="dropdown-header pb-3">
                    <strong>Quick Links</strong>
                </div>

                <div class="quick-links-grid">
                    <a href="#" class="ql-grid-item">
                        <i class="  ti-files text-primary"></i>
                        <span class="ql-grid-title">New Task</span>
                    </a>
                    <a href="#" class="ql-grid-item">
                        <i class="  ti-check-box text-success"></i>
                        <span class="ql-grid-title">Assign Task</span>
                    </a>
                </div>
                <div class="quick-links-grid">
                    <a href="#" class="ql-grid-item">
                        <i class="  ti-truck text-warning"></i>
                        <span class="ql-grid-title">Create Orders</span>
                    </a>
                    <a href="#" class="ql-grid-item">
                        <i class=" icon-layers text-info"></i>
                        <span class="ql-grid-title">New Orders</span>
                    </a>
                </div>

            </div>
        </li> --}}

        <li class="nav-item dropdown dropdown-slide mr-5">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{asset('assets/img/user.png')}}" alt="John Doe">
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
                <div class="dropdown-header pb-3">
                    <div class="media d-user">
                        <img class="align-self-center mr-3" src="{{asset('assets/img/user.png')}}" alt="John Doe">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">{{auth()->user()->first_name}}</h5>
                            <span>{{auth()->user()->email}}</span>
                        </div>
                    </div>
                </div>

                <a class="dropdown-item " href="{{ url('profile') }}">
                 <i class=" ti-user"></i>
                 Profile
                </a>

                  <a class="dropdown-item " href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                      <i class=" ti-unlock"></i>
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
            </div>
        </li>

        <!--right side toggler-->
        {{-- <li class="nav-item d-lg-none">
            <button class="navbar-toggler mobile-rightside-toggler" type="button"><i class="icon-options-vertical"></i></button>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link navbar-toggler right-sidebar-toggler" href="#"><i class="icon-options-vertical"></i></a>
        </li> --}}
    </ul>

    <!--right side nav end-->
</header>
<!--===========header end===========-->
