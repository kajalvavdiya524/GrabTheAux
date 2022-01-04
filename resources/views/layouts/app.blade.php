<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
  <script src="https://source.zoom.us/1.7.9/lib/vendor/jquery.min.js"></script>

    <!--google font-->
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!--common style-->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/lobicard/css/lobicard.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/themify-icons/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/weather-icons/css/weather-icons.min.css')}}" rel="stylesheet">

    <!--custom css-->
    <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">

   <!-- Yajra datatable css -->
    <link href="{{asset('assets/vendor/data-tables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
  <!-- End Yajra datatable css -->

  <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/html5shiv.js"></script>
    <script src="assets/vendor/respond.min.js"></script>
    <![endif]-->
    <script src="{{ mix('css/app.css') }}" type="text/javascript"></script>


  <title>Grab The Aux</title>
  <link rel="icon" href="{{ asset('assets/img/favicon.jpg') }}" type="image/jpg" sizes="16x16">



</head>





<body class="app header-fixed left-sidebar-light left-sidebar-light-alt left-sidebar-fixed right-sidebar-fixed right-sidebar-overlay right-sidebar-hidden">

  <div id="app">
        @yield('content')
        @stack('scripts')
  </div>

      <!-- Placed js at the end of the page so the pages load faster -->

      <script src="{{asset('assets/vendor/popper.min.js')}}"></script>
      <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('assets/vendor/jquery-ui-touch/jquery.ui.touch-punch-improved.js')}}"></script>
      <script src="{{asset('assets/vendor/lobicard/js/lobicard.js')}}"></script>
      <script class="include" type="text/javascript" src="{{asset('assets/vendor/jquery.dcjqaccordion.2.7.js')}}"></script>
      <script src="{{asset('assets/vendor/jquery.scrollTo.min.js')}}"></script>


      <!--[if lt IE 9]>
      <script src="assets/vendor/modernizr.js"></script>
      <![endif]-->

      <!--init scripts-->
      <script src="{{asset('assets/js/scripts.js')}}"></script>

        <!-- yajra datatable js -->
        <script src="{{asset('assets/vendor/data-tables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/vendor/data-tables/dataTables.bootstrap4.min.js')}}"></script>

        <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
        <script src="/vendor/datatables/buttons.server-side.js"></script>
        <!--init-->
        <script src="{{asset('assets/vendor/b4-datatable-init.js')}}"></script>
        <script src="{{asset('assets/vendor/ajax-table-init.js')}}"></script>
        <!-- end yajra datatable js -->
        @stack('vue_scripts')
        {{-- <script src="{{ mix('js/app.js') }}" type="text/javascript"></script> --}}
  </body>
  </html>
