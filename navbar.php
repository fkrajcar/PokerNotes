<?php
if (isset($_SESSION["loggedin"])) {
    include "popup_form.php";
} ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="container p-0">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <?php if (isset($_SESSION["loggedin"])) { ?>
      <li class="nav-item">
        <a class="nav-link" href="home.php">Home</a>
      </li>
      <li class="nav-item">
        <!--<a href="main.php" class="btn">Input</a>-->
      </li>
      <li class="nav-item">
        <a href="sessions.php" class="nav-link">Sessions</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    	<li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?= $_SESSION["username"] ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="account.php">Account</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
    <?php } else { ?>
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      </ul>
    <?php } ?>

    <!--
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  --></div>
  </div>
</nav>