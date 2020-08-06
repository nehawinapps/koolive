<?php
include("config.php");
session_start();
//$conn = mysqli_connect("localhost", "koofamil_B277", "rSFihHas];1P", "koofamil_B277");
// $conn = mysqli_connect("localhost","root","","koofamil_b277");
// Login 
    if (isset($_POST['loginbtn'])) 
    {
        
        $name = $_POST['name'];       
        $nric = $_POST['nric'];

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
                $r_code=$row['rider_code'];
                $product_id=$row['product_id'];
                

                
                $_SESSION["rider_name"]=$name;

                $_SESSION["rider_code"]=$r_code;
				//echo $_SESSION["rider_name"];
                
                $_SESSION["nric"]=$nric;
                $_SESSION["id"]=$id;
                $_SESSION["product_id"]=$product_id;
                }

                header("location:rider_logbook.php");

                 }

                 else
                 {
                     header("location:register.php");
                 }
   		 }
	 			else
                 {
                     header("location:register.php");
                 }

   
    }
 ?>       