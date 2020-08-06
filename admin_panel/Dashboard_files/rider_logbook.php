<?php
session_start();

include("config.php");
$conn = mysqli_connect("localhost", "koofamil_B277", "rSFihHas];1P", "koofamil_B277");
// $conn = mysqli_connect("localhost","root","","adminpanel");

//  if(!$_SESSION["rider_name"])
//  {
//  	header("location:register.php");
//  }


$rider_name=@$_SESSION['rider_name'];
$nric=@$_SESSION['nric'];
$id=$_SESSION['id'];

//echo @$_SESSION['rider_name'];


if(isset($_POST['done_btn']))
{
    
    @$comments = $_POST['comments'];

    @$rating = $_POST['rating'];


    $query="UPDATE  rider SET 
    comments='$comments',
    rating='$rating'
    WHERE Id='$id'
    ";
    mysqli_query($conn,$query);
}
    

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
  </div>
  <div class="ml-auto mr-3">
     <h2><?php echo @$_SESSION['rider_name'];?></h2>
  </div>
  <div class="ml-auto mr-3 p-3">
  <input type="submit" name="logoutbtn" value="Logout">
  </div>
  </form>
</div>
</div>
<br><br>
<div class="container">
<div class="container table-responsive">
  <table class="table table-striped">
  
<?php
        $query3="SELECT * from rider
        WHERE Id='$id'

        
         ";

       $query_run= mysqli_query($conn,$query3);

      while( $row=mysqli_fetch_array($query_run))
      {
       
?>
    <thead>
      <tr>
        <!-- <th>Sr. No.</th> -->
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <!-- <th>Ratings</th>
        <th>Comments</th> -->
      </tr>
    </thead>
    <tbody>
      <tr>
        <!-- <td>1</td> -->
        <td><?php echo $row['date'];?></td>
        <td><?php echo $row['time'];?></td>
        <td><?php echo $row['work_area'];?></td>
        
      </tr>
      
    </tbody>
  </table>

  <?php }



?>
</div>

</div>

    <!-- scripts  -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>














