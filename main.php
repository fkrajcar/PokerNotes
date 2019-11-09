<?php
require 'config.php';

session_start();
if (isset($_SESSION["username"])) { ?>
  <html>
  <head>
  <title>Data input</title>
  <?php include 'header.php'; ?>
  </head>
  <?php include 'navbar.php'; ?>
  <div class="container">
        <form action="session_input.php" method="post" name="session_input">
          <div class="form-group">
            <label for="buyin">Buy-in</label>
            <input type="text" class="form-control" name="buyin" id="buyin" required>
          </div>
          <div class="form-group">
            <label for="buyout">Buy-out</label>
            <input type="text" class="form-control" name="buyout" id="buyout" required>
          </div>
          <div class="form-group">
            <label for="stakes">Stakes</label>
            <select multiple class="form-control" id="stakes" name="stakes" required>
              <option value="1">0.25/0.50</option>
              <option value="2">0.50/1</option>
              <option value="3">2/5</option>
              <option value="4">5/10</option>
              <option value="5">50/100</option>
            </select>
          </div>
          <div class="row">
          <div class="form-group col-md-6">
            <label for="hours">Hours</label>
            <input type="number" class="form-control" name="hours" id="hours" min="0" max="24" required>
          </div>
          <div class="form-group col-md-6">
            <label for="minutes">Minutes</label>
            <input type="number" class="form-control" name="minutes" id="minutes" min="1" max="59" required>
          </div>
        </div>


          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</div>
        
<?php } else {echo 'Please log in first.<br>';
    sleep(2);
    header('Location: home.php');}
?>
</html>