<?php
	// Initialize the session
	session_start();
	require 'config.php';

	$sql = "DELETE FROM session_info WHERE username='".$_SESSION["username"]."'";
	if(!mysqli_query($link, $sql)) {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}

	$sql = "UPDATE total_info set total=0, duration=0, per_hour=0, cashed=0, total_sessions=0, per_session=0, bankroll=0, bb_per_hour=0, bb_per_session=0 WHERE username='".$_SESSION["username"]."'";
	if(!mysqli_query($link, $sql)) {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}

	header('Location: '.$_SERVER["HTTP_REFERER"]);
	exit;
