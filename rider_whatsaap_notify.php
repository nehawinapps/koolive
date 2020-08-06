<?php

include("config.php");
session_start();
$product_id=$_SESSION["product_id"];







if(isset($_POST['r_code']))
{
  $r_code= $_POST['r_code'];
}
//echo $product_id;

if(isset($_POST['r_id']))
{
  //echo $_POST['r_id'];
}

date_default_timezone_set('Asia/Kolkata');

$assign_time = date('h:i:s');


if(isset($_POST['r_id']))
{

//	echo $r_code;
$r_id=$_POST['r_id'];
//echo $r_id;



 $query2="UPDATE rider 
	SET product_id='$r_id',
	assign_job='false',
	assign_time='$assign_time'

	WHERE rider_code='$r_code'
  ";
	 mysqli_query($conn,$query2);
	 

	 $query4="SELECT name FROM rider WHERE rider_code='$r_code' ";
	 $res=mysqli_query($conn,$query4);
	while($row= mysqli_fetch_array($res))
	{
		$name=$row['name'];
//echo $name."<br>name";
  }
  
	?>
<div class="container bg-success">
	<table class="table">
		<tr>
			<th>Order <?php echo $r_id;?> <span style="color: red;">Assigned To :</span> </th>
			<th>Rider Code : <?php echo $r_code;?></th>
			<th>Rider Name : <?php echo $name;?></th>

		</tr>
	</table>
</div>
<?php }

else{
?>
  <div class="container bg-success">
  <table class="table">
    <tr>
      <th>You can re-assign the order for <?php echo $a ?></th>

    </tr>
  </table>
</div>
<?php
}






// $q3="SELECT assign_time FROM rider WHERE product_id='$product_id' ";
// $n=mysqli_query($conn,$q3);
// while($col=mysqli_fetch_array($n))
// {
//     $time=$col['assign_time'];
//     echo $time."<br>";
// }

// $old_time=$time;

// $endTime = strtotime("+4 minutes", strtotime($old_time));
// $new_time= date('h:i:s', $endTime);
// echo $new_time;


//new

// date_default_timezone_set('Asia/Kolkata');

// $current = date('h:i:s');
// echo "assign";
// echo $current;






//echo $m;
//end 

if(isset($_POST['free']))  
{
    $f=$_POST['free'];
   // echo $f;
   

    $query2="UPDATE rider 
	SET product_id='',
	assign_job='true',
  assign_time=''
	WHERE product_id='$product_id'
  ";
     mysqli_query($conn,$query2);

}

// $query="select rider.name as rider_name,rider.Id as riders_id,order_list.*,u.merchant_remark,u.google_map as merchant_map,u.name as merchant_name,u.mobile_number as merchant_mobile_number from order_list inner join 
// users as u on u.id=order_list.merchant_id  left join rider on order_list.rider_id=rider.Id   ";

 $query="SELECT  * FROM users 
 INNER JOIN order_list ON users.id=order_list.user_id
 INNER join whatsaap_group on order_list.id=whatsaap_group.whatsaap_id
 


 WHERE whatsaap_group.whatsaap_id='$product_id'
 LIMIT 0,1
 
 ";


if (empty($_SESSION["langfile"])) { $_SESSION["langfile"] = "english"; }
    

$current_time = date('Y-m-d H:i:s');
function ceiling($number, $significance = 1)
{
	return ( is_numeric($number) && is_numeric($significance) ) ? (ceil(round($number/$significance))*$significance) : false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
  <h2>Latest Rider Order</h2>
          
  <table class="table">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Order Id</th>
	
        
        <th>Order Remark</th>
        <th>Order Status</th>
        
			<th>Merchant Detail</th>
			
			<th>Merchant Remark</th>
			<th>DATE OF ORDER</th>
        <th>Merchant Address </th>
      
		
		   
      </tr>
    </thead>



    <tbody>
	<?php 
     $qu=mysqli_query($conn,$query);
	 $i=1;
	 while($r=mysqli_fetch_array($qu))
	 {
		 $dteDiff  = date_diff($date, date_create($current_time));
                              $diff_day = $dteDiff->d;
                              if($diff_day != '0') $diff_day .= ' days ';
                              else $diff_day = '';
                              $diff_hour = $dteDiff->h;
                              if(intval($diff_hour) < 10) $diff_hour = '0'.$diff_hour.':'; else $diff_hour = $diff_hour.':';
                              $diff_minute = $dteDiff->i;
                              if($diff_minute < 10) $diff_minute = '0'.$diff_minute.':'; else $diff_minute = $diff_minute.':';
                              $diff_second = $dteDiff->s;
                              if($diff_second < 10) $diff_second = '0'.$diff_second;
                              $diff_time = $diff_day.'<br>'.$diff_hour.$diff_minute.$diff_second;	
	    if($r['merchant_map'])
		{
			$location_m=rawurlencode($r['merchant_map']);
			$m_map="http://maps.google.com/maps?q=".$location_m;
		}
	?>
      <tr>  
      <td><?php echo $i; ?></td>
      <td><?php echo $r['whatsaap_id']; ?></td>
        

    
        <td><?php echo $r['remark_extra'] ?></td>
        <form action="" method="post">

<!-- accept button  -->



        <td>
        <?php if($current=="null" ){
              echo "time out";
            //echo $product_id;

            $query3="UPDATE rider 
            SET product_id='',
            assign_job='true',
            assign_time=''
            WHERE product_id='$product_id'
            ";
              mysqli_query($conn,$query3);

         ?>


       
        <?php }else{

          
          ?>
          <!-- <button type="submit" class="btn btn-warning" name="accept" value="accept">Accept Order</button><br><br> -->
     <?php
        } ?>


<button class="btn btn-info " type="button" data-target="#orderdetailmodel" data-toggle="modal"   value="<?php echo $r_n; ?>">Accept </button>
		



<div class="modal fade" id="orderdetailmodel" role="dialog" style="margin-top:12%;">
		
        <div class="modal-dialog">
        <!-- Modal content-->		
          <div class="modal-content">	
              <div class="modal-header">	
              <button type="button" class="close" data-dismiss="modal">&times;</button>						
              <h4 class="modal-title">Order Detail <?php echo $job_assign; ?></h4>
              <?php echo $r['id']; ?>	
              </div>		
                        
            <form id ="orderdetailform" method="POST" >	
            <input type="hidden" id="access_order_id" name="access_order_id"/>
            <div class="modal-body" style="padding-bottom:0px;">
                  <div class="form-group">
                    <label for="usr">Access Key:</label>
                    <input type="hidden" name="r_id" value="<?php echo $r['id']; ?>" >
                    <input type="password" name="r_code" class="form-control" id="btnSubmit">
                  </div>

                  <div class="form-group">
                  
                  <!-- <input type="hidden" name="rider" value="<?php //echo @$r_n ; ?>" > -->
                    <input type="submit" class="form-control btn btn-primary" name="access" value="Access">
                  </div>
            </div>
          </div>
        </div>
    
     
        </form>
        <td><?php echo $r['user_name']." / ".$r['user_mobile']; ?></td>
		<td><?php echo $r['merchant_remark']; ?></td>
		
        

<!-- 
		 <td><?php //echo date_format($date,"m/d/Y h:i A");  ?>
                                <?php //echo '<br>'; echo $new_time[1] ?>
                                <?php 
                                //  if($row['status'] == 0){?>
                                    <p style="color: red;"><?php //echo $diff_time; ?></p> <?php 
                                 // }?>
                            </td>    -->
        <td><?php echo $r['created_timestamp']; ?></td>
		
        <td><a href="<?php echo $m_map; ?>" target="_blank"><?php echo $r['google_map']; ?></a></td>
        



      </tr>
	 <?php $i++;} ?>   
      
    </tbody>
  </table>
 </div>  
    

    <script>
        
$(document).ready(function(){
	$(".assign_order").click(function(e){
		  var s_id = $(this).attr('order_id');
		  $('#access_order_id').val(s_id);
		 $("#orderdetailmodel").modal("show"); 
	  });  
	 

    </script>
</body>
</html>