<?php

include("config.php");
session_start();
//$nric=$_SESSION['nric_reg'];

//echo $nric;
// $conn = mysqli_connect("localhost","root","","adminpanel");

//$conn = mysqli_connect("localhost", "koofamil_B277", "rSFihHas];1P", "koofamil_B277");
$feedback_id=$_POST['feedback_id'];
$nric_id=$_POST['nric_id'];
//echo $nric_id;

// $query2="SELECT nric FROM rider WHERE Id='$feedback_id' ";
// $run=mysqli_query($conn,$query2);
// $row=mysqli_fetch_array($run);
// $nric = $row['nric'];
// echo $nric;



    if(isset($_POST['feedback_id']))
    {
        $feedback_id=$_POST['feedback_id'];
       // echo $feedback_id;
    }

        
    if(isset($_POST['done_btn']))
    {
        date_default_timezone_set('Asia/Kolkata');

        
$current_date= date('Y-m-d');

//echo time('h:i:s');

$current_Time = date('h:i:s');
   // echo $current_Time;
        
        @$comments = $_POST['comments'];
        @$nric_new = $_POST['nric_new'];

       // echo $nric_new;

        @$rating = $_POST['rating'];
// echo $comments;

        // $query="INSERT INTO comment (rating,comments,nric) values('$rating','$comments','$nric')  ";

        // $query="SELECT rating FROM comment WHERE Id='1' ";
        $query="INSERT into comment (rating,comments,nric,currentdate,currenttime) values('$rating','$comments','$nric_new','$current_date','$current_Time')";
        $query_run=mysqli_query($conn,$query);
        // if($row=mysqli_fetch_array($query_run))
		// {
			

		// 	echo $row['rating'];
       	 header("location:riders.php");

		// }
    
	}
	
	if(isset($_POST['close']))
	{
		header("location:riders.php");
	}
    ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Feedback</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<br>
<div class="text-white container bg-success">
<form action="rider_logout.php" method="post">
<div class="row ml-1">
  
  <div class="ml-auto mr-3">
     <h2>Feedback To Rider</h2>
  </div>
  <div class="ml-auto mr-3 p-3">
  <!-- <input type="submit" name="logoutbtn" value="Logout"> -->
  </div>
  </form>
</div>
</div>
<br><br>


<div class="container">
<div class="container table-responsive">

<form action="" method="post">
  <table class="table table-striped">

  <div class="modal-body">
			<div class="form-group" >
                <label for="">Rating </label><br/>
                <input type="radio" name="rating" value="1" class="">1
                <input type="radio" name="rating" value="2" class="">2
                <input type="radio" checked name="rating" value="3" class="">3
                <input type="radio" name="rating" value="4" class="">4
                <input type="radio" name="rating" value="5" class="">5
            </div>

            <div class="form-group">
                <label for="">Comments</label>
                <textarea name="comments" id="" class="form-control" placeholder="eg. You are doing well.." cols="5" rows="5"></textarea>
            </div>

        </div>
        <div class="modal-footer">
            <input type="hidden" name="nric_new" value="<?php echo $nric_id; ?>" />
            <button type="submit" name="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="done_btn" class="btn btn-primary">Done</button>
         </div>
      </form>


</table>

</div>
</div>