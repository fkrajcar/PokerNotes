<?php
// Initialize the session
session_start();
require 'config.php';
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="mb-5 container">
        <div class="row">
            <div class="col-md-6">
                <?php
                if (isset($_GET['stakes'])) {
                    $stakes = $_GET['stakes'];
                } else {
                    $stakes = 0;
                }
                $user = $_SESSION["username"];
                $sql =
                    "SELECT total, duration, per_hour, cashed, total_sessions, per_session, bb_per_hour, bb_per_session FROM total_info where username='$user' and stakes='" .
                    $stakes .
                    "'";
                $result = $link->query($sql);
                $row = $result->fetch_assoc();
                $total_sessions = $row['total_sessions'];
                ?>

                <script language="javascript" type="text/javascript">
                    function doReload(catid){
                        document.location = 'home.php?stakes=' + catid;
                    }
                </script>

                <div class="row mb-3">
                    <form id="home_stakes" class="form-inline col-md-12" method="GET" name="courseselect" >
                        <label class="my-1 mr-2" for="stakes">Stakes:</label>
                        <select onChange="doReload(this.value);" class="custom-select my-1 mr-sm-2 col-md-4" id="stakes" name="stakes">
                            <option value="0" <?php if ($stakes == "0") {
                                echo 'selected="selected"';
                            } ?>>All</option>
                            <option value="0.5" <?php if ($stakes == "0.5") {
                                echo 'selected="selected"';
                            } ?>>.25/.50</option>
                            <option value="1" <?php if ($stakes == "1") {
                                echo 'selected="selected"';
                            } ?>>0.50/1</option>
                            <option value="5" <?php if ($stakes == "5") {
                                echo 'selected="selected"';
                            } ?>>2/5</option>
                            <option value="10" <?php if ($stakes == "10") {
                                echo 'selected="selected"';
                            } ?>>5/10</option>
                            <option value="100" <?php if ($stakes == "100") {
                                echo 'selected="selected"';
                            } ?>>50/100</option>
                        </select>
                    </form>
                </div>
                <h3>Info</h3>
                <ul class="list-group">
                  <li class="list-group-item"><span class="font-weight-bold">Total</span>: <span class="<?php if (
                      $row['total'] > 0
                  ) {
                      echo "text-success";
                  } else {
                      echo "text-danger";
                  } ?>"><?= $row['total'] ?>kn</span></li>
                  <li class="list-group-item"><span class="font-weight-bold">Duration</span>: <?= intdiv(
                      $row['duration'],
                      60
                  ) ?> hours, <?= $row['duration'] % 60 ?> minutes</li>
                  <li class="list-group-item"><span class="font-weight-bold">kn/hour</span>: <span class="<?php if (
                      $row['per_hour'] > 0
                  ) {
                      echo "text-success";
                  } else {
                      echo "text-danger";
                  } ?>"><?= round($row['per_hour'], 2) ?></span></li>
                  <li class="list-group-item"><span class="font-weight-bold">kn/session</span>: <span class="<?php if (
                      $row['per_session'] > 0
                  ) {
                      echo "text-success";
                  } else {
                      echo "text-danger";
                  } ?>"><?= round($row['per_session'], 2) ?></span></li>
                  <?php if (isset($stakes) && $stakes != 0) { ?>
                    <li class="list-group-item"><span class="font-weight-bold">BB/session</span>: <span class="<?php if (
                        $row['bb_per_session'] > 0
                    ) {
                        echo "text-success";
                    } else {
                        echo "text-danger";
                    } ?>"><?= round($row['bb_per_session'], 2) ?></span></li>
                    <li class="list-group-item"><span class="font-weight-bold">BB/hour</span>: <span class="<?php if (
                        $row['bb_per_hour'] > 0
                    ) {
                        echo "text-success";
                    } else {
                        echo "text-danger";
                    } ?>"><?= round($row['bb_per_hour'], 2) ?></span></li>
                    <?php } ?>
                  <li class="list-group-item"><span class="font-weight-bold">Sessions</span>: <?= $row[
                      'total_sessions'
                  ] ?></li>
                  <li class="list-group-item"><span class="font-weight-bold">Cashed sessions</span>: <?= $row[
                      'cashed'
                  ] ?></li>
                </ul>
            
            
            
            
                <?php if ($total_sessions != 0) {
                    echo '<canvas class="mt-5" id="myChart" width="300" height="300"></canvas>';
                } ?>
            
                <!--<script type="text/javascript" src="myjs.js"></script>-->
                <script>
                    var ctx = document.getElementById("myChart");
                    data = {
                        datasets: [{
                            data: [<?= $row['cashed'] ?>, <?= $row[
    'total_sessions'
] - $row['cashed'] ?>],
                            backgroundColor: ["#b1dfbb","#f1b0b7"]
                        }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: [
                            'Cashed',
                            'Lost'
                        ]
                    };
                    var myPieChart = new Chart(ctx,{
                        type: 'pie',
                        data: data
                    });
                </script>
            </div>
        
            <div class="col-md-6 marg_bott">
                <?php
                $lim_num = 6;
                $user = $_SESSION["username"];
                $sql = "SELECT itemid, stakes, buyin, buyout, date_time FROM session_info where username='$user' ";
                if ($stakes != 0) {
                    $sql = $sql . "and stakes='" . $stakes . "' ";
                    $lim_num = 8;
                }
                $sql = $sql . "order by date_time DESC LIMIT " . $lim_num;
                $result = $link->query($sql);

                echo '<h3>Last ' . $lim_num . ' sessions</h3>';
                if ($result->num_rows > 0) {
                    // output data of each row
                    echo '<div class="row list-group">';

                    while ($row = $result->fetch_assoc()) {
                        $date = date('d.m.Y.', strtotime($row['date_time']));
                        $profit = $row['buyout'] - $row['buyin'];
                        echo "<a href='session_info.php?itemid=" .
                            $row['itemid'] .
                            "' class='list-group-item list-group-item-action ";

                        if ($profit > 0) {
                            echo "list-group-item-success'>";
                        } else {
                            echo "list-group-item-danger'>";
                        }
                        echo "<span>" .
                            $date .
                            "</span><span class='ml-4'>Stakes: NL" .
                            $row['stakes'] .
                            "</span><div class='total total-front'><span class='float-left'>Profit:</span><span class='float-right'>" .
                            $profit .
                            "</span></div></a>";
                    }
                } else {
                    echo "<div class='list-group-item list-group-item-dark'>0 results</div>";
                }
                ?>
            </div>
            <?php if ($total_sessions != 0) {
                echo '<a class="btn btn-text float-right" href="sessions.php?show=' .
                    $stakes .
                    '">View all sessions</a><canvas class="mt-5" id="linechart" width="300" height="300"></canvas>';
            } ?>
            <script>
                var linechart = document.getElementById("linechart");
                <?php
                $user = $_SESSION["username"];
                $sql = "SELECT profit FROM session_info where username='$user' ";
                if ($stakes != 0) {
                    $sql = $sql . "and stakes='" . $stakes . "' ";
                }
                $result = $link->query($sql);
                $row = $result->fetch_assoc();
                $array = [];
                $prev = 0;
                array_push($array, floatval($prev));
                if ($result->num_rows > 0) {
                    $prev = floatval($prev) + floatval($row['profit']);
                    array_push($array, floatval($prev));
                    while ($row = $result->fetch_assoc()) {
                        $prev = floatval($prev) + floatval($row['profit']);
                        array_push($array, floatval($prev));
                    }
                }
                $js_array = json_encode($array);
                ?>
                var data_array = <?= $js_array ?>;
                console.log(data_array);

                var tocke_grafa = []; //array za tocke grafa
                var labels = [];
                var pts = [];

                        //uzmi JSON za tocke grafa
                $.each(data_array, function (key, value) {
                    labels.push(key);
                    pts.push( parseFloat(value).toFixed(2));
                });
                /*
                new Chart(document.getElementById("chartjs-0"),
                    {
                        "type":"line",
                        "data":{
                            "labels":["January","February","March","April","May","June","July"],
                            "datasets":[
                                {
                                    "label":"My First Dataset",
                                    "data":[65,59,80,81,56,55,40],
                                    "fill":false,"borderColor":
                                    "rgb(75, 192, 192)",
                                    "lineTension":0.1
                                }
                            ]
                        },
                        "options":{}
                    }
                );
                */
                console.log(tocke_grafa);
                var myLineChart = new Chart(linechart, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: pts,
                            fill: false,
                            label: "Winnings",
                            borderColor:"#007bff",
                        }]
                    },
                    options: {
                        elements: {
                            line: {
                                tension: 0
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</div>
</div>
</body>
</html>