<?php
session_start();
require 'config.php';

$username = $_SESSION["username"];
$buyin = floatval( mysqli_real_escape_String($link, $_REQUEST['buyin']) );
$buyout = floatval( mysqli_real_escape_String($link, $_REQUEST['buyout']) );
$stakes = mysqli_real_escape_String($link, $_REQUEST['stakes']);
$hours = intval(mysqli_real_escape_String($link, $_REQUEST['hours']));
$minutes = intval(mysqli_real_escape_String($link, $_REQUEST['minutes']));
$date_time = date("Y-m-d H:i:s");



$profit = $buyout - $buyin;
// Attempt insert query execution
$sql = "INSERT INTO session_info (username, buyin, buyout, stakes, hours, minutes, date_time, profit) VALUES ('$username', '$buyin', '$buyout', '$stakes', '$hours', '$minutes', '$date_time', '$profit')";
if(!mysqli_query($link, $sql)) {
	echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


$duration = $hours*60+$minutes;
$cashed = 0;
if($profit>0){
	$cashed = 1;
}

$sql2 = "UPDATE total_info SET total = total+".$profit.", duration=duration+".$duration.", per_hour=total/(duration/60), cashed=cashed+".intval($cashed).", total_sessions=total_sessions+1, per_session=total/total_sessions WHERE username='".$username."' and stakes=0";
if(!mysqli_query($link, $sql2)) {
    echo "error";
} else {
	$sql2 = "UPDATE total_info SET total = total+".$profit.", duration=duration+".$duration.", per_hour=total/(duration/60), cashed=cashed+".intval($cashed).", total_sessions=total_sessions+1, per_session=total/total_sessions WHERE username='".$username."' and stakes='".$stakes."'";
	if(!mysqli_query($link, $sql2)) {
	    echo "error";
	} else {
		$sql2 = "UPDATE total_info SET bb_per_hour=(total/stakes)/(duration/60), bb_per_session=total/total_sessions/stakes WHERE username='".$username."' and stakes='".$stakes."'";
		mysqli_query($link, $sql2);

	    header('Location: '.$_SERVER["HTTP_REFERER"]);
	    exit;
	}
}




 
// Close connection
mysqli_close($link);

?>