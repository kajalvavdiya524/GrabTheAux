@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')
    <div class="app-body">
        @include('layouts.partials._leftSideNav')
        <main class="main-content">

            <div class="container-fluid">

                <div class="card-group no-shadow mb-4 mt-4">

                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12">
                                    <strong>General results</strong>
                                </div>
                                <div class="col-xl-6 col-sm-12 col pt-4 pb-3">
                                    <div id="sparkline_1"> </div>
                                    <div class="mt-2">Followers 12.2322</div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col">
                                    <div class="ep_1" data-percent="48"><span>48</span>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12">
                                    <strong>Ratings by category</strong>
                                </div>
                                <div class="col-xl-6 col-sm-12 col pt-4 pb-3">
                                    <div id="sparkline_2"> </div>
                                    <div class="mt-2">Followers 5.2121</div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col">
                                    <div class="ep_2" data-percent="75"><span>75</span>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12">
                                    <strong>This month reports</strong>
                                </div>
                                <div class="col-xl-6 col-sm-12 col pt-4 pb-3">
                                    <div id="sparkline_3"> </div>
                                    <div class="mt-2">Followers 21.3221</div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col">
                                    <div class="ep_3" data-percent="63"><span>63</span>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- state start-->
                <div class="row">
                    <div class=" col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="donut-chart" style="height: 310px"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <i class="fa fa-dot-circle-o text-info"></i>
                                        <span>Daily</span>
                                    </div>
                                    <div class="col">
                                        <i class="fa fa-dot-circle-o text-primary"></i>
                                        <span>Weekly</span>
                                    </div>
                                    <div class="col">
                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                        <span>Monthly</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="icon-people text-primary f30"></i>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="m-0">New Users</h6>
                                        <p class="f12 mb-0">32 New Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="icon-basket-loaded text-info f30"></i>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="m-0">Order Placed</h6>
                                        <p class="f12 mb-0">123 New Order Placed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-3">
                                        <i class=" icon-handbag text-danger f30"></i>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="m-0">Delivery </h6>
                                        <p class="f12 mb-0">54 New Delivery</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-3">
                                        <i class=" icon-badge text-success f30"></i>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="m-0">Monthly Profits</h6>
                                        <p class="f12 mb-0">$9887 This Month Profit
                                            <span class="float-right text-success"> </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-4">
                        <div class="card mb-4">
                            <div class="card-body pb-0">
                                <div class="btn-group float-right">
                                    <div class="dropdown ">
                                        <a href="#" class="btn btn-transparent default-color dropdown-hover p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class=" icon-options"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right ">
                                            <a class="dropdown-item" href="#"> <i class="icon-note text-info pr-2"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i class="icon-close text-danger pr-2"></i> Delete</a>
                                            <a class="dropdown-item" href="#"><i class="icon-shield text-warning pr-2"></i> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mb-0">12083</h4>
                                <p class="">Yearly Revineue</p>
                            </div>
                            <div class="px-4">
                                <canvas id="myChart3-light" height="100"></canvas>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body pb-0">
                                <div class="btn-group float-right">
                                    <div class="dropdown ">
                                        <a href="#" class="btn btn-transparent default-color dropdown-hover p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class=" icon-options"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right ">
                                            <a class="dropdown-item" href="#"> <i class="icon-note text-info pr-2"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i class="icon-close text-danger pr-2"></i> Delete</a>
                                            <a class="dropdown-item" href="#"><i class="icon-shield text-warning pr-2"></i> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mb-0 ">9876</h4>
                                <p class=""> Total Profit</p>
                            </div>
                            <div class="px-">
                                <canvas id="myChart4-light" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- state end-->

                <div class="row">
                    <!--Report widget start-->
                    <div class="col-xl-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                    Product Reports
                                    <div class="btn-group float-right task-list-action">
                                        <div class="dropdown ">
                                            <a href="#" class="btn btn-transparent default-color dropdown-hover p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class=" icon-options"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right ">
                                                <a class="dropdown-item" href="#"> <i class="fa fa-calendar-o text-info pr-2"></i> Daily</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-calendar-check-o text-danger pr-2"></i> Weekly</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-calculator text-warning pr-2"></i> Monthly</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vertical-middle">
                                    <thead>
                                    <tr>
                                        <th class="border-0 ">Product Thumb</th>
                                        <th class="border-0">Product Info</th>
                                        <th class="border-0 text-right">Total Sold</th>
                                        <th class="border-0 text-right">Rating</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="width: 150px">
                                            <img src="assets/img/product_img.jpg" alt="" style="width: 80px; height: auto"/>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">15" Mackbook Pro Retina Display</h6>
                                            <span class="f12">Category: Computer Electronics</span>
                                            <div class="text-muted">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-empty"></i>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="text-muted">2345</h4>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="text-muted">123</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px">
                                            <img src="assets/img/product_2.jpg" alt="" style="width: 80px; height: auto"/>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">27" iMac Por Latest versin</h6>
                                            <span class="f12">Category: Computer Electronics</span>
                                            <div class="text-muted">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-empty"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="text-muted">4321</h4>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="text-muted">432</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px">
                                            <img src="assets/img/product_3.jpg" alt="" style="width: 80px; height: auto"/>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">iPhone X</h6>
                                            <span class="f12">Category: Mobile</span>
                                            <div class="text-muted">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="text-muted">5442</h4>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="text-muted">788</h4>
                                        </td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--<td style="width: 150px">-->
                                    <!--<img src="assets/img/product_3.jpg" alt="" style="width: 80px; height: auto"/>-->
                                    <!--</td>-->
                                    <!--<td>-->
                                    <!--<h6 class="mb-0">Mac mini pro Dual core</h6>-->
                                    <!--<span class="f12">Category: Computer device</span>-->
                                    <!--<div class="text-muted">-->
                                    <!--<i class="fa fa-star"></i>-->
                                    <!--<i class="fa fa-star"></i>-->
                                    <!--<i class="fa fa-star"></i>-->
                                    <!--<i class="fa fa-star-o"></i>-->
                                    <!--<i class="fa fa-star-o"></i>-->
                                    <!--</div>-->
                                    <!--</td>-->
                                    <!--<td class="text-right">-->
                                    <!--<h4 class="text-muted">12334</h4>-->
                                    <!--</td>-->
                                    <!--<td  class="text-right">-->
                                    <!--<h4 class="text-muted">45</h4>-->
                                    <!--</td>-->
                                    <!--</tr>-->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--Report widget end-->

                    <!--weather widget start-->
                    <div class="col-xl-5">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 d-flex justify-content-center">
                                        <div class="align-self-center ">
                                            <i class="wi wi-day-sleet f60 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <small>SUN, Jan 2018 10:21  </small>
                                        <h6>Most Cloudy</h6>
                                        <h1 class="mt-3 mb-3 p-2 border border-right-0 border-left-0 text-primary"> 34<sup>o c</sup></h1>
                                        <span>Wind: SE 15 KM/H</span>
                                        <p>Huminity: 54%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white text-center">
                                <div class="row">
                                    <div class="col">
                                        <p class="f12">MON</p>
                                        <i class="wi wi-day-cloudy f30"></i>
                                        <p class="mb-0 mt-2">18<sup>o c</sup></p>
                                    </div>
                                    <div class="col">
                                        <p class="f12">TUE</p>
                                        <i class="wi  wi wi-day-rain-mix f30"></i>
                                        <p class="mb-0 mt-2">13<sup>o c</sup></p>
                                    </div>
                                    <div class="col">
                                        <p class="f12">WED</p>
                                        <i class="wi  wi wi-day-cloudy-windy f30"></i>
                                        <p class="mb-0 mt-2">29<sup>o c</sup></p>
                                    </div>
                                    <div class="col">
                                        <p class="f12">THU</p>
                                        <i class="wi  wi wi-day-sprinkle f30"></i>
                                        <p class="mb-0 mt-2">32<sup>o c</sup></p>
                                    </div>
                                    <div class="col">
                                        <p class="f12">FRI</p>
                                        <i class="wi  wi wi-day-thunderstorm f30"></i>
                                        <p class="mb-0 mt-2">09<sup>o c</sup></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--weather widget end-->
                </div>

            </div>
        </main>
        <!--main contents end-->

        <!--right sidebar start-->
        <aside class="right-sidebar">

            <!--notification widget start-->
            <div class="widget">
                <h3 class="mb-4 widget-title">Notification</h3>

                <div class="notification-list">
                    <ul class="list-unstyled">
                        <li>
                            <div class="nt-thumb mr-3">
                                <img src="assets/img/n1.png" alt=""/>
                            </div>
                            <div class="nt-info">
                                <a href="#"  class="nt-title">Diverse Ltd.</a>
                                <small class="text-muted">2 days ago</small>
                                <p><a href="#">www.diverse-test.com</a></p>
                            </div>
                        </li>
                        <li>
                            <div class="nt-thumb mr-3">
                                <img src="assets/img/n3.png" alt=""/>
                            </div>
                            <div class="nt-info">
                                <a href="#"  class="nt-title">Black Friday Discount Offer</a>
                                <small class="text-muted">2 days ago</small>
                                <p>Nam libero tempore cum soluta nobis est eligendi.</p>
                            </div>
                        </li>

                        <li>
                            <div class="nt-thumb mr-3">
                                <img src="assets/img/n2.png" alt=""/>
                            </div>
                            <div class="nt-info">
                                <a href="#"  class="nt-title">Task Failed</a>
                                <small class="text-muted">2 days ago</small>
                                <p>Error: Invalid command found ... after [this class]</p>
                            </div>
                        </li>

                        <li>
                            <div class="nt-thumb mr-3">
                                <img src="assets/img/n4.png" alt=""/>
                            </div>
                            <div class="nt-info">
                                <a href="#"  class="nt-title">John Doe</a>
                                <small class="text-muted">3 days ago</small>
                                <p>Send you a contact request.</p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <!--notification widget end-->

            <!--Active log widget start-->
            <div class="widget">
                <h3 class="mb-4 widget-title">Activity Log</h3>
                <div class="baseline baseline-border">
                    <div class="baseline-list">
                        <div class="baseline-info">
                            <div><a href="#" class="default-color"><strong>John Tasi</strong></a> Prepare for the Meeting <span class="badge badge-pill badge-success">status</span></div>
                            <span class="text-muted">10:00 PM Sat, 10 Jan 2018</span>
                        </div>
                    </div>
                    <div class="baseline-list baseline-border baseline-primary">
                        <div class="baseline-info">
                            <div>Video conference to client</div>
                            <span class="text-muted">05:00 PM Sun, 02 Feb 2018</span>
                        </div>
                    </div>
                    <div class="baseline-list  baseline-border baseline-success">
                        <div class="baseline-info">
                            <div><a href="#" class="default-color"><strong>Tnisha</strong></a> Submit a blog post <a href="#" class="">best admin template in 2018.</a></div>
                            <span class="text-muted">10:00 PM Sat, 10 Jan 2018</span>
                        </div>
                    </div>
                    <div class="baseline-list  baseline-border baseline-warning">
                        <div class="baseline-info">
                            <div><a href="#" class="default-color"><strong>New Request</strong></a> 10 user request to approve or remove</div>
                            <span class="text-muted">10:00 PM Sat, 10 Jan 2018</span>
                        </div>
                    </div>
                    <div class="baseline-list  baseline-border baseline-info">
                        <div class="baseline-info">
                            <div><a href="#" class="default-color"><strong>Mark Henry</strong></a> added your friend list now</div>
                            <span class="text-muted">10:00 PM Sat, 10 Jan 2018</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--Active log widget end-->

            <!--stock widget start-->
            <div class="widget">
                <h3 class="mb-4 widget-title">Stocks</h3>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>DOW</td>
                            <td>1999</td>
                            <td>
                                <span class="badge badge-pill badge-primary">+ 0.10%</span>
                            </td>
                        </tr>
                        <tr>
                            <td>AAPL</td>
                            <td>1299</td>
                            <td>
                                <span class="badge badge-pill badge-success">- 0.50%</span>
                            </td>
                        </tr>
                        <tr>
                            <td>SBUX</td>
                            <td>1099</td>
                            <td>
                                <span class="badge badge-pill badge-danger">+ 0.20%</span>
                            </td>
                        </tr>
                        <tr>
                            <td>NKE</td>
                            <td>2199</td>
                            <td>
                                <span class="badge badge-pill badge-warning">+ 1.25%</span>
                            </td>
                        </tr>
                        <tr>
                            <td>YOO</td>
                            <td>999</td>
                            <td>
                                <span class="badge badge-pill badge-info">+ 3.00%</span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--stock widget end-->

        </aside>
        <!--right sidebar end-->

    </div>
    <!--===========app body end===========-->

      @include('layouts.partials._footer')

  @endsection
