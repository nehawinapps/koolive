<?php

session_start();

include("config.php");
//$conn = mysqli_connect("localhost", "koofamil_B277", "rSFihHas];1P", "koofamil_B277");
// $conn = mysqli_connect("localhost","root","","adminpanel");

//  if(!$_SESSION["rider_name"])
//  {
//  	header("location:register.php");
//  }
$r_code=@$_SESSION["rider_code"];

$rider_name=@$_SESSION['rider_name'];
$nric=@$_SESSION['nric'];
$id=$_SESSION['id'];

//echo @$_SESSION['rider_name'];

    

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider LogBook</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div class="text-white container bg-primary">
<form action="rider_logout.php" method="post">
<div class="row ml-1">
  <div>
     <h2><strong>LogBook</strong></h2>
     Rider Code <?php echo @$r_code; ?>
  </div>
  <div class="ml-auto mr-3">
     <h2><?php echo @$_SESSION['rider_name'];?></h2>
  </div>
  <div class="ml-auto mr-3 p-3">
  <a href="riderorder_login.php"><input type="button" value="View orders" /></a>
  <input type="submit" name="logoutbtn" value="Logout">
  
  </div>
  </form>
</div>
</div>
<br><br>
<div class="container">
<div class="container table-responsive">
  <table class="table table-striped">
  
  <tr>
        <th>Trips</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <th>Ratings</th>
        <th>Comments</th>
        <th>Change Status</th>
      </tr>
<?php

//rider table
      





$query3="SELECT * FROM rider 
INNER JOIN comment ON comment.nric=rider.nric where  rider.nric='$nric' ";

$i=1;
       $query_run= mysqli_query($conn,$query3);

      while( $row=mysqli_fetch_array($query_run))
      {
       
?>
    <thead>
      
    </thead>
    <tbody>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $row['currentdate'];?></td>
        <td><?php echo $row['currenttime'];?></td>
        <td><?php echo $row['work_area'];?></td>
        <td><?php echo $row['rating'];?></td>
        <td><?php echo $row['comments'];?></td>
        <td><a href="#" class="btn btn-danger">Delivered</a></td>
        
      </tr>
      

  <?php $i++; }



?>

</tbody>
  </table>
</div>

</div>

    <!-- scripts  -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>














