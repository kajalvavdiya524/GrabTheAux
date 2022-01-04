<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
  <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/fontawesome.min.css" integrity="sha512-kJ30H6g4NGhWopgdseRb8wTsyllFUYIx3hiUwmGAkgA9B/JbzUBDQVr2VVlWGde6sdBVOG7oU8AL35ORDuMm8g==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://source.zoom.us/1.7.10/lib/vendor/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


        <script src="{{ mix('css/app.css') }}" type="text/javascript"></script>

  <title>Grab The Aux</title>
  <link rel="icon" href="{{ asset('assets/img/favicon.jpg') }}" type="image/jpg" sizes="16x16">

  <style>

    #zmmtg-root{
      background-color:transparent!important;
      position:relative!important;

    }
    #wc-loading{
        width: 100% !important;
        height: 600px !important;
        /* margin: 1% !important; */
        /* display: none !important; */
  }
  </style>

</head>


<body class="app header-fixed left-sidebar-light left-sidebar-light-alt left-sidebar-fixed right-sidebar-fixed right-sidebar-overlay right-sidebar-hidden">

  <div id="app">
        @yield('content')
        @stack('scripts')
  </div>

        <!-- end yajra datatable js -->
        @stack('vue_scripts')
        {{-- <script src="{{ mix('js/app.js') }}" type="text/javascript"></script> --}}
  </body>
  </html>
