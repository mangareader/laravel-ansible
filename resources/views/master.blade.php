<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url("/") }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url("/") }}/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{ url("/") }}/css/_all-skins.min.css">
    <link rel="stylesheet" href="{{ url("/") }}/css/custom.css">
    @yield('styles')
</head>
<body class="skin-purple layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="../../index2.html" class="navbar-brand"><b>Admin</b>LTE</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="">Dashboard</a></li>
                        <li><a href="{{ route("inventories") }}">Inventories</a></li>
                        <li><a href="{{ route("template") }}">Job Template</a></li>
                        <li><a href="{{ route("jobs") }}">Jobs</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>

    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <!--<section class="content-header">
                <h1>
                    Top Navigation
                    <small>Example 2.0</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>-->

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- jQuery 2.1.4 -->
<script src="{{ url("/") }}/js/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ url("/") }}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ url("/") }}/js/app.min.js" type="text/javascript"></script>
<script src="{{ url("/") }}/js/custom.js" type="text/javascript"></script>
@yield('scripts')
</body>
</html>