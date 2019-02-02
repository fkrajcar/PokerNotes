<?php
// Initialize the session
session_start();
require 'config.php';
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$itemid=$_GET['itemid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session info</title>
    <?php include 'header.php'; ?>
</head>
<body>
	<?php 
		include 'navbar.php'; 

        $user = $_SESSION["username"];
        $sql = "SELECT itemid, stakes, buyin, buyout, date_time, profit, hours, minutes FROM session_info WHERE username='$user' AND itemid='$itemid'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        $date = date('d.m.Y. H:m', strtotime($row['date_time']));
        $duration = $row['hours']*60+$row['minutes'];
        $duration = $duration/60;
	?>
	<div class="container">
	<ul class="list-group">
		<li class="list-group-item"><span class="font-weight-bold">Date</span>: <?= $date; ?></li>
      
      <li class="list-group-item"><span class="font-weight-bold">Profit</span>: <span class="<?php if ($row['profit']>0){
        echo "text-success";
      }else echo "text-danger"; ?>"><?= $row['profit']; ?>kn</span></li>
      <li class="list-group-item"><span class="font-weight-bold">BB/hour</span>: <span class="<?php if ($row['profit']>0){
        echo "text-success";
      }else echo "text-danger"; ?>"><?= round(floatval($row['profit']/$duration/$row['stakes']), 2); ?>kn</span></li>
      <li class="list-group-item"><span class="font-weight-bold">kn/hour</span>: <span class="<?php if ($row['profit']>0){
        echo "text-success";
      }else echo "text-danger"; ?>"><?= round(floatval($row['profit']/$duration), 2); ?>kn</span></li>
      <li class="list-group-item"><span class="font-weight-bold">Duration</span>: <?= $row['hours']; ?> hours, <?= $row['minutes']; ?> minutes</li>
      <li class="list-group-item"><span class="font-weight-bold">Buy-in</span>: <?= $row['buyin']; ?>kn</li>
      <li class="list-group-item"><span class="font-weight-bold">Buy-out</span>: <?= $row['buyout']; ?>kn</li>
      
      <li class="list-group-item"><span class="font-weight-bold">Stakes</span>: NL<?= $row['stakes']; ?></li>
    </ul>
    <a class="btn btn-primary btn-danger mt-3" href='delete_session.php?itemid=<?= $itemid; ?>'>Delete session</a><br />
</div>
</body>
</html>
