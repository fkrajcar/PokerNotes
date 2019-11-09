<?php
// Initialize the session
session_start();
require 'config.php';

$sql =
    "DELETE FROM session_info WHERE username='" . $_SESSION["username"] . "'";
if (!mysqli_query($link, $sql)) {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "DELETE FROM total_info WHERE username='" . $_SESSION["username"] . "'";
if (!mysqli_query($link, $sql)) {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "DELETE FROM users WHERE username='" . $_SESSION["username"] . "'";
if (!mysqli_query($link, $sql)) {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
} else {
    header('Location: login.php');
    session_destroy();
    exit();
}
