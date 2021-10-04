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



                                    <div id="classReach" class="row">


                                    </div>
                                    <!-- ./col -->

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

                                    <div id="freqClass" class="row"></div>
                                    <!-- ./col -->

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
        <script src="dist\js\circle-progress.min.js"></script>


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
                    // Reach Class
                    let classArray = [];
                    response['class'].forEach(function(items) {
                        classArray.push(items);
                    });

                    let reachClassObject = {};
                    for (var reachClass of classArray) {
                        reachClassObject = reachClass;
                    }
                    $('#classReach').empty();
                    for (var key in reachClassObject) {
                        createEmptyDiv(key);
                    }
                    $('#classReach').hide().show(0);
                    for (var key in reachClassObject) {
                        addCircleProgress(reachClassObject[key] / 100, key);
                    }


                    //Class Frequency
                    let freqClass = [];
                    response['freq'].forEach(function(items) {
                        freqClass.push(items);
                    });

                    let freqClassObject = {};
                    for (var freq of freqClass) {
                        freqClassObject = freq;
                    }

                    $("#freqClass").empty();
                    var avg_freq = response['avg-freq'];
                    for (const key in freqClassObject) {
                        //change block color based on the avg freq value
                        if (freqClassObject[key] >= avg_freq) {

                            createNumberBlock(key, freqClassObject[key], 'bg-success');
                        } else if (freqClassObject[key] >= (avg_freq / 2) && freqClassObject[key] <
                            avg_freq) {
                            createNumberBlock(key, freqClassObject[key], 'bg-danger');


                        } else if (freqClassObject[key] < (avg_freq / 2)) {
                            createNumberBlock(key, freqClassObject[key], 'bg-warning');

                        }
                    }





                }

            });
        }

        function addCircleProgress(value, id) {
            let divID = document.getElementById(id);
            $(divID).circleProgress({
                value: value,
                size: 150,
                fill: {
                    gradient: ["red", "orange"]
                }
            }).on('circle-animation-progress', function(event, progress, stopValue) {
                $(this).parent().find("strong").text(String(stopValue.toFixed(2).substr(2)) + '%');
            });



        }

        function createEmptyDiv(id) {
            let outterDiv = document.createElement('div');
            outterDiv.style.cssText = 'margin: 20px;';


            let newDiv = document.createElement('div');
            newDiv.setAttribute('id', id);
            newDiv.style.cssText = 'position: relative;';

            let percentage = document.createElement('strong');
            percentage.style.cssText =
                'position: absolute; top: 50px; left: 0px; width: 100%; text-align: center; line-height: 40px; font-size: 30px;';

            let titleNode = document.createElement('span');
            let title = document.createTextNode(id);
            titleNode.style.cssText = 'display: block; color: red; margin-top: 12px; margin-left: 45px;';

            titleNode.appendChild(title);

            newDiv.appendChild(percentage)
            newDiv.appendChild(titleNode);


            outterDiv.appendChild(newDiv);

            let currentDiv = document.getElementById('classReach');
            currentDiv.appendChild(outterDiv);
        }

        function createNumberBlock(key, value, color) {
            var outerMostDiv = document.createElement("div");
            outerMostDiv.className = 'col-lg-3 col-6';

            var outterDiv = document.createElement("div");
            outterDiv.className = "small-box " + color;

            outterDiv.setAttribute("id", "freqClassBlock");

            var innerDiv = document.createElement("div");
            innerDiv.className = 'inner';

            var textValue = document.createElement('h3');
            var t = document.createTextNode(value);
            textValue.appendChild(t);

            var title = document.createElement('p');
            var subT = document.createTextNode(key);
            title.appendChild(subT);

            innerDiv.appendChild(textValue);
            innerDiv.appendChild(title);

            outterDiv.appendChild(innerDiv);

            outerMostDiv.appendChild(outterDiv);

            var currentDiv = document.getElementById('freqClass');

            currentDiv.insertBefore(outerMostDiv, null);

        }




        // function addElement(key, value, id) {
        //     var newDiv = document.createElement("div");
        //     //newDiv.className = "col-6 col-md-3 text-center";

        //     var inputField = document.createElement("input");
        //     inputField.setAttribute("type", "text");
        //     inputField.setAttribute("value", value);
        //     inputField.className = "knob";
        //     inputField.setAttribute("data-width", "90");
        //     inputField.setAttribute("data-height", "90");
        //     inputField.setAttribute("data-fgColor", "#00c0ef");
        //     inputField.setAttribute("id", "inputStyle")


        //     var title = document.createElement('div');
        //     title.className = 'knob-label';
        //     var reachClassName = document.createTextNode(key);

        //     title.empty.appendChild(reachClassName);


        //     newDiv.empty.appendChild(inputField);
        //     newDiv.empty.appendChild(title);
        //     var currentDiv = document.getElementById(id);
        //     currentDiv.insertBefore(newDiv, null);
        // }
        </script>

        <!-- jQuery UI 1.11.4 -->
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.js"></script>








</body>

</html>