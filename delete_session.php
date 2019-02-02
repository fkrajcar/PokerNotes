<?php
	// Initialize the session
	session_start();
	require 'config.php';
	$itemid = $_GET['itemid'];
	$username = $_SESSION["username"];



	$sql = "SELECT buyin, buyout, stakes, hours, minutes, date_time, itemid, profit FROM session_info WHERE username='$username' AND itemid='$itemid'";
	$result = $link->query($sql);
	$row = $result->fetch_assoc();
	$duration = $row['hours']*60+$row['minutes'];
	$cashed = 0;
	if($row['profit']>0){
		$cashed = 1;
	}
	$sql2 = "UPDATE total_info SET total = total-".$row['profit'].", duration=duration-".$duration.", per_hour=total/(duration/60), cashed=cashed-".intval($cashed).", total_sessions=total_sessions-1, per_session=total/total_sessions WHERE username='".$username."' and stakes=0";
	if(!mysqli_query($link, $sql2)) {
	    echo "error";
	} 
	else {
		$sql2 = "UPDATE total_info SET total = total-".$row['profit'].", duration=duration-".$duration.", per_hour=total/(duration/60), cashed=cashed-".intval($cashed).", total_sessions=total_sessions-1, per_session=total/total_sessions WHERE username='".$_SESSION['username']."' and stakes='".$row['stakes']."'";
		if(!mysqli_query($link, $sql2)) {
		    echo "error";
		} 
		else {
		$sql2 = "UPDATE total_info SET bb_per_hour=(total/stakes)/(duration/60), bb_per_session=total/total_sessions/stakes WHERE username='".$_SESSION['username']."' and stakes='".$row['stakes']."'";
		mysqli_query($link, $sql2);  
		}
	}

	$sql = "DELETE FROM session_info WHERE username='".$_SESSION["username"]."' and itemid='$itemid'";
	if(!mysqli_query($link, $sql)) {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}

	$sql = "SELECT username FROM session_info WHERE username='$username'";
	$result = $link->query($sql);
	$row = $result->fetch_assoc();

	if ($result->num_rows==0) {
		$sql2 = "UPDATE total_info SET total = 0, duration=0, per_hour=0, cashed=0, total_sessions=0, per_session=0, bb_per_hour=0, bb_per_session=0 WHERE username='".$username."'";
		mysqli_query($link, $sql2);
	}

	
	header('Location: home.php');
	exit;
