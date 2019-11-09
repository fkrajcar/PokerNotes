<?php
// Initialize the session
session_start();
require 'config.php';
?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h3 class="mb-4">Account options</h3>
        <div id="alert" style="display:none;" class="alert alert-success">Your data has been deleted!</a>
        </div>

        <ul class="list-group">
          <li class="list-group-item"><div class="acc_row"><span class="font-weight-bold">Reset all your data:</span> <a id="reset_data" class="btn btn-primary btn-danger ml-5" href='#'>Proceed</a></div></li>
          <li class="list-group-item"><div class="acc_row"><span class="font-weight-bold">Reset your password:</span> <a class="btn btn-primary ml-5" href='reset-password.php'>Proceed</a></div></li>
          <li class="list-group-item"><div class="acc_row"><span class="font-weight-bold">Delete account:</span> <a onclick="return confirm('Are you sure? This action will delete your account!');" class="btn btn-primary btn-danger ml-5" href='delete_user.php'>Proceed</a></div></li>
        </ul>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#reset_data").click(function(e){
                    if(confirm("Are you sure? This action will delete all your data!")){
                        $.ajax({
                            type: 'POST',
                            url: 'delete_data.php',
                            success: function(data) {
                                $('#alert').show("slow");
                            }
                        });
                    }
                    else{
                        e.preventDefault();
                    }   
                });
            });
        </script>
    </div>
</body>
</html>