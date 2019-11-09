<?php
session_start();
require 'config.php';
?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h3 class="mb-4">About</h3>
        <p>This web-app is my student project, so bugs are likely to appear.</p>

        <h5>Contact</h5>
        <p><i class="far fa-envelope"></i><a href="mailto:fixilon@gmail.com">fixilon@gmail.com</a><br />
        	<i class="fab fa-github"></i><a href="https://github.com/fkrajcar">github.com/fkrajcar</a>
        </p>
    </div>
</body>
</html>