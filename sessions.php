<?php
session_start();
require 'config.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if (isset($_GET['order'])){
    $order = $_GET['order'];
}
else
    $order = 'date_time';

if (isset($_GET['show'])){
    $show = $_GET['show'];
}else{
    $show = "0";
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sessions</title>
    <?php include 'header.php' ?>
</head>
<body>
    <?php 
    include 'navbar.php'; 
    $user = $_SESSION["username"];

    $sql = "SELECT itemid, stakes, buyin, buyout, date_time, profit FROM session_info where username='$user' ";
    if(isset($show) && $show!='and profit>0' && $show!='and profit<=0' && $show!='0'){
        $sql = $sql."and stakes='".$show."' ";
    }else if($show=='and profit>0' || $show=='and profit<=0'){
        $sql = $sql.$show." ";
    }
    $sql = $sql."order by ".$order." DESC";

    $result = $link->query($sql);
    ?>
    <div class="container mb-5">
        <div class="row mb-4">
            <h3 class="col-md-5">All sessions 
                <?php if($show=="and profit>0"){
                    echo "(Winning)";
                }else if($show=="and profit<=0") echo "(Losing)";
                else if($show=="0") ;
                else{
                    echo "(NL".$show.")";
                } echo " [".$result->num_rows."]"; ?>
            </h3>
            <script language="javascript" type="text/javascript">
                function doReload(catid){
                    document.location = 'sessions.php?show=' + catid +'&order=' + $('#order').val() ;
                }
                function doReload_order(catid){
                    document.location = 'sessions.php?order=' + catid +'&show=' + $('#show').val();
                }
            </script>
            <div class="col-md-7">
                <form class="form-inline float-right" method="GET" name="courseselect" >
                    <label class="my-1 mr-2" for="order">Order by:</label>
                    <select onChange="doReload_order(this.value);" class="custom-select my-1 mr-sm-2" id="order" name="order">
                        <option value="date_time" <?php if ($order == "date_time") echo 'selected="selected"'; ?>>Date</option>
                        <option value="profit" <?php if ($order == "profit") echo 'selected="selected"'; ?>>Profit</option>
                        <option value="stakes" <?php if ($order == "stakes") echo 'selected="selected"'; ?>>Stakes</option>
                        <option value="buyin" <?php if ($order == "buyin") echo 'selected="selected"'; ?>>Buy-in</option>
                        <option value="buyout" <?php if ($order == "buyout") echo 'selected="selected"'; ?>>Buy-out</option>
                    </select>
                    <label class="my-1 mr-2" for="show">Show:</label>
                    <select onChange="doReload(this.value);" class="custom-select my-1 mr-sm-2" id="show" name="show">
                        <option value="0" <?php if ($show == "0") echo 'selected="selected"'; ?>>All</option>
                        <option value="0.5" <?php if ($show == "0.5") echo 'selected="selected"'; ?>>.25/.50</option>
                        <option value="1" <?php if ($show == "1") echo 'selected="selected"'; ?>>0.50/1</option>
                        <option value="5" <?php if ($show == "5") echo 'selected="selected"'; ?>>2/5</option>
                        <option value="10" <?php if ($show == "10") echo 'selected="selected"'; ?>>5/10</option>
                        <option value="100" <?php if ($show == "100") echo 'selected="selected"'; ?>>50/100</option>
                        <option value="and profit>0" <?php if ($show == "and profit>0") echo 'selected="selected"'; ?>>Winning</option>
                        <option value="and profit<=0" <?php if ($show == "and profit<=0") echo 'selected="selected"'; ?>>Losing</option>
                    </select>
                </form>
            </div>
        </div>
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                echo '<div class="row list-group">';

                while($row = $result->fetch_assoc()) {

                    $date = date('d.m.Y. H:i:s', strtotime($row['date_time']));
                    $profit = $row['buyout'] - $row['buyin'];
                    echo "<a href='session_info.php?itemid=".$row['itemid']."' class='list-group-item list-group-item-action ";

                    if($profit>0){
                        echo "list-group-item-success";
                    } 
                    else echo "list-group-item-danger";
                    echo "'><span class='date'>".$date."</span><div class='total float-right'><span class='float-left'>Total for session:</span><span class='float-right'>".$profit. "</span></div><span class='ml-4 col-md-3'>Stakes: NL" .$row["stakes"]. "</a>";
                      //<a href="#" class="list-group-item list-group-item-action ">A simple danger list group item</a>
                }
                
            } 
            else {
                echo "<div class='list-group-item list-group-item-dark'>0 results</div>";
            }
            ?>
        </div>
    </div>
    </div>
</body>
</html>