<?php 

require_once('config.php');


$conn = new Connection();
$teamID = 1;

$userIDs = $conn->getUserIDFromTeamID($teamID);
$callTarget = $conn->teamCallTarget($teamID);



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
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

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
            <div class="content-header">


                <h1>Select UserID:</h1>

                <select name="userID" id="userID" onchange="this.form.submit()">
                    <option value="select_user">Select an USER</option>
                    <?php
                    foreach($userIDs as $user):?>
                    <option value=<?=$user->userID?>><?=$user->userName;?></option>

                    <?php endforeach;?>
                </select>



            </div>
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
                    <!-- displaying the Call Rate  -->
                    <div class="row" id="kpi_cr">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-light">
                                <div class="inner">
                                    <h3 id="prevDayCR">-</h3>

                                    <p>Yesterday's CR</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-call"></i>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-light">
                                <div class="inner">
                                    <h3 id="prevDayCR">-</h3>

                                    <p>Previous 5 days CR</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-light">
                                <div class="inner">
                                    <h3 id="prevDayCR">-</h3>

                                    <p>Previous Cycle CR</p>
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
                                        Reach % for Different Class
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">

                                    <div class="row">

                                        <div id="classReach"></div>
                                        <!-- ./col -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
            </section>

            <hr>
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
                                        Frequency for Different Class
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
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
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </section>








            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <?php include 'components/footer.php';?>


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

        <!-- jQuery Knob Chart -->
        <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>

        <!-- Summernote -->
        <script src="plugins/summernote/summernote-bs4.min.js"></script>

        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>




        <!-- Getting Call Rate -->
        <script type="text/javascript">
        $("#userID").on("change", function(e) {
            e.preventDefault();

            var selectedUserID = $('#userID').val();
            if (selectedUserID == "select_user") {
                $("#preDay").addClass("bg-light");
                $("#pre5").addClass("bg-light");
                $("#preCycle").addClass("bg-light");
                $("#prevDayCR").html("User not selected!");
                $("#prev5DayCR").html("User not selected!");
                $("#cycleCR").html("User not selected!");

            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        userID: selectedUserID,
                        teamID: 1,
                    },
                    url: "call_rate.php",
                    cache: false,
                    success: function(response) {
                        $('#kpi_cr').html(response);
                        getReachClass(selectedUserID);

                    }

                });
            }



        });

        function getReachClass(selectedUserID) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: {
                    userID: selectedUserID,
                    teamID: 1,
                },
                url: "reach_class_percentage.php",
                cache: false,
                success: function(response) {
                    let classArray = [];
                    response['class'].forEach(function(items) {
                        classArray.push(items);
                    });

                    let reachClassObject = {};
                    for (const reachClass of classArray) {
                        reachClassObject = reachClass;
                    }

                    console.log(Object.keys(reachClassObject).length);
                    // for (const key in reachClassObject) {

                    // }

                    //create div elements and then add attributes using js



                }

            });
        }
        </script>


</body>

</html>