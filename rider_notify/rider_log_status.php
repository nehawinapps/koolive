<?php
include("config.php");
session_start();
 $id=$_SESSION['id'];
      if(isset($_SESSION["msg"]) !="")
      {
        unset($_SESSION["msg"]);
      }
 //echo $id;

// Login 
    if (isset($_POST['loginbtn'])) 
    {
        
        $name = $_POST['name'];       
        $nric = $_POST['nric'];

        //echo "hello";
        //echo $name."  ".$nric;
        
        $query = "SELECT * FROM rider WHERE name='$name' AND nric='$nric' ";
        $query_run = mysqli_query($conn,$query);

        //$res = mysqli_fetch_array($query_run);
      if($query_run)
      {


                $numrow=mysqli_num_rows($query_run);
                if($numrow!=0)
                {
                    // $_SESSION["rider_name"]=$name;
                    
                while($row=mysqli_fetch_array($query_run))
                {
                 
                // $dnric= $row['nric'];
                
                $id=$row['Id'];
                 $product_id=$row['product_id'];
                
        //         $_SESSION["rider_nam"]=$name;
				// echo $_SESSION["rider_nam"];
                
        //         $_SESSION["nric"]=$nric;
        //         $_SESSION["id"]=$id;
        //          $_SESSION["product_id"]=$product_id;
                
                }

               // echo $id;
                $_SESSION["msg"]="";
                header("location:rider_login.php?id=$id");

                 }

                 else
                 {
                   $_SESSION["msg"]="wrong details";
                     header("location:rider_notify.php");
                 }
   		 }
	 			else
                 {
                  $_SESSION["msg"]="wrong details";
                     header("location:rider_notify.php");
                 }

   
    }
 ?>       
<!-- <body onload="myFunction()">


<p>Click the button to display a confirm box.</p>

<button onclick="">Try it</button>

<p id="demo"></p>

<script>
function myFunction() {
  var txt;
  var r = confirm("Press a button!");
  if (r == true) {
    txt = "You pressed OK!";

  } else {
    txt = "You pressed Cancel!";



  }
  document.getElementById("demo").innerHTML = txt;
}
</script> -->

