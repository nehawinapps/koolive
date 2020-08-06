<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h2>Say Yes or No ?</h2><br>    
<form action="" method="post">
    <button type="submit" class="btn btn-success" name="yes" value="y">Yes</button>
    <button type="submit" class="btn btn-warning" name="no" value="n">No</button>
</form>
</div>

    
</body>
</html>

<?php
include("config.php");


//session_start();
//$id=$_SESSION["id"];
?>



<?php
if(isset($_GET['id']))
{
    $r_id=$_GET['id'];
//echo $r_id;
$_SESSION['id']=$r_id;
}


if(isset($_POST['yes']))
{
    $yes=$_POST['yes'];
    //header("location:riderorder_login.php");
    
    
}
else if(isset($_POST['no']))
{
    $yes=$_POST['no'];
    //session_destroy();
}


 $query= "UPDATE rider SET
      status='$yes'
      WHERE Id='$r_id'";
     mysqli_query($conn,$query);
     
       

     

?>
</body>
</html>