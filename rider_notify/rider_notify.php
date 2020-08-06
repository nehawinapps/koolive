<?php 
include("config.php");
session_start();

// if($_SESSION["msg"]!=="")
// {
//     $_SESSION["msg"]="";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="container">

    <h2><?php echo @$_SESSION["msg"]; ?></h2>
    <h2>Are You interested to work?</h2>
    <form action="rider_log_status.php" method="post">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" required="required" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="">NRIC No.</label>
            <input type="text" required="required" name="nric" class="form-control">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-secondary ">Close</button>
            <button type="submit" name="loginbtn" class="btn btn-primary ">Login</button>
         </div>
    </form>
</div>
</body>
</html>
<?php
 if(isset($_SESSION["msg"]) !="")
 {
   unset($_SESSION["msg"]);
 }
?>

