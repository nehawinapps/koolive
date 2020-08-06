<?php

include("config.php");
session_start();
$product_id=$_SESSION["product_id"];









//echo $product_id;


$q3="SELECT assign_time FROM rider WHERE product_id='$product_id' ";
$n=mysqli_query($conn,$q3);
while($col=mysqli_fetch_array($n))
{
    $time=$col['assign_time']; //database time
    //echo $time."<br>";
}

$old_time=$time;

$endTime = strtotime("+4 minutes", strtotime($old_time)); // 4mints added to databse time
$new_time= date('h:i:s', $endTime);
//echo $new_time;


//new

date_default_timezone_set('Asia/Kolkata');

$current = date('h:i:s');
//echo "assign";
//echo $current;






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

//accept button

if(isset($_POST['accept']))
{
   $accept=$_POST["accept"];

    $sql="UPDATE rider
    SET assign_time=''
    WHERE product_id='$product_id'
    ";
    mysqli_query($conn,$sql);
}
else
{
  $accept='null';
}

// $query="select rider.name as rider_name,rider.Id as riders_id,order_list.*,u.merchant_remark,u.google_map as merchant_map,u.name as merchant_name,u.mobile_number as merchant_mobile_number from order_list inner join 
// users as u on u.id=order_list.merchant_id  left join rider on order_list.rider_id=rider.Id   ";

 $query="SELECT  * FROM users 
 INNER JOIN order_list ON users.id=order_list.user_id
 left join rider on order_list.id=rider.product_id
 WHERE rider.product_id='$product_id'
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
</head>
<body>
<div class="container">
  <h2>Latest Rider Order</h2>
          
  <table class="table">
    <thead>
      <tr>
        <th>S.No</th>
		<th>Rider info</th>
		<th>Rider name</th>
        
        <th>Order Remark</th>
        <th>Order Status</th>
        
			<th>Merchant Detail</th>
			
			<th>Merchant Remark</th>
			<th>DATE OF ORDER</th>
        <th>Merchant Address </th>
      
		
		   
      </tr>
    </thead>
<?php 

    


?>







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

        <td><?php echo $r['nric'] ?></td>
        <td><?php echo $r['name'] ?></td>
        <td><?php echo $r['remark_extra'] ?></td>
        <form action="" method="post">

<!-- accept button  -->
<?php 


?>


        <td>
        <?php if($current >= $new_time && $accept=='null' ){
              echo "Time out";
           // echo $product_id;

            $query4="INSERT INTO whatsaap_group   (whatsaap_id) values('$product_id') ";
            mysqli_query($conn,$query4);


            $query3="UPDATE rider 
            SET product_id='',
            assign_job='true',
            assign_time=''
            WHERE product_id='$product_id'
            ";
              mysqli_query($conn,$query3);

              $whatapp_group_name="Kulai-New order rider";
              $sms_msg= 'http://koofamilies.com/demo1/demo.html';
           // echo $sms_msg;
              
              //whatappgroupmsg($whatapp_group_name, $sms_msg);

             
         ?>


       
        <?php }else{

          
          ?>
          
            <button type="submit" class="btn btn-warning" name="accept" value="accept">Accept Order</button><br><br>
          
          
            <button type="submit" class="btn btn-success" name="free" value="free">To Deliver</button>
          
     <?php
        } ?>


        
    
     
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
    
</body>
</html>