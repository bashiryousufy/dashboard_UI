<?php 
require_once('config.php');

session_start();
$email = "bashiryousufy@gmail.com";
$conn = new Connection();

if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = $conn->getUserID($email);
}



$oneDayDuration = $conn->checkPrevDayOnField($_SESSION['userID']);

$PrevCR = 0;
//Calculate only if Field Day Duration is greater than Zero
if ($oneDayDuration > 0) {
    $onFieldDuration =  1- $oneDayDuration ;
    $totalCalls = $conn->totalCallsForOneDay($_SESSION['userID']);
    if($onFieldDuration > 0){
        $PrevCR = $totalCalls->totalcalls/$onFieldDuration;
    }

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AX3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        <?php include 'components/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'components/side-bar.php';?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Call Rate Stats</h1>
                        </div><!-- /.col -->
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?=$PrevCR; ?></h3>

                                    <p>PrevDay CR</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-call"></i>
                                </div>

                            </div>
                        </div>

                        <!-- <sup style="font-size: 20px">%</sup> -->
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>-</h3>

                                    <p>P5Days CR</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>-</h3>

                                    <p>Current Cycle Call Rate</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-sync"></i>
                                </div>

                            </div>
                        </div>


                    </div>
                </div> <!-- /.row -->



            </section>

            <hr>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Reach for Different Class</h1>
                        </div><!-- /.col -->
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <!-- jQuery Knob -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="far fa-chart-bar"></i>
                                        jQuery Knob
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 col-md-3 text-center">
                                            <input type="text" class="knob" value="30" data-width="90" data-height="90"
                                                data-fgColor="#3c8dbc">

                                            <div class="knob-label">New Visitors</div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-6 col-md-3 text-center">
                                            <input type="text" class="knob" value="70" data-width="90" data-height="90"
                                                data-fgColor="#f56954">

                                            <div class="knob-label">Bounce Rate</div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-6 col-md-3 text-center">
                                            <input type="text" class="knob" value="-80" data-min="-150" data-max="150"
                                                data-width="90" data-height="90" data-fgColor="#00a65a">

                                            <div class="knob-label">Server Load</div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-6 col-md-3 text-center">
                                            <input type="text" class="knob" value="40" data-width="90" data-height="90"
                                                data-fgColor="#00c0ef">

                                            <div class="knob-label">Disk Space</div>
                                        </div>
                                        <!-- ./col -->
                                    </div>
                                    <!-- /.row -->

                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <input type="text" class="knob" value="90" data-width="90" data-height="90"
                                                data-fgColor="#932ab6">

                                            <div class="knob-label">Bandwidth</div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-6 text-center">
                                            <input type="text" class="knob" value="50" data-width="90" data-height="90"
                                                data-fgColor="#39CCCC">

                                            <div class="knob-label">CPU</div>
                                        </div>
                                        <!-- ./col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
            </section>






            <?php include 'components/footer.php';?>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>