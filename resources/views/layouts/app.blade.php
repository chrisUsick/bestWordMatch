<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Laravel Quickstart - Basic</title>

    <!-- CSS And JavaScript -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    {{-- <link href="css/bootstrap.min.css" rel="stylesheet"> --}}


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{asset('css/app.css')}}" rel="stylesheet"/>
  </head>

  <body>

    <div class="container">
      <!-- Navigation -->
      <nav class="navbar navbar-inverse " role="navigation">
          <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Start Bootstrap</a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                      <li>
                          <a href="#">About</a>
                      </li>
                      <li>
                          <a href="#">Services</a>
                      </li>
                      <li>
                          <a href="#">Contact</a>
                      </li>
                  </ul>
              </div>
              <!-- /.navbar-collapse -->
          </div>
          <!-- /.container -->
      </nav>

    <!-- Page Content -->

      @yield('content')
      <hr>

      <!-- Footer -->
      <footer>
          <div class="row">
              <div class="col-lg-12">
                  <p>Copyright &copy; cu-dev.ca 2015</p>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
      </footer>

    </div>
    <!-- /.container -->

    <script src="{{asset('js/babel-polyfill.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/all.js')}}" type="text/javascript"></script>
    <!-- <script src="{{asset('js/lib.js')}}" type="text/javascript"></script> -->
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    @yield('scripts')
  </body>
</html>
