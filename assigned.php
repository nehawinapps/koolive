<?php
include('config.php');

	$query = "SELECT * FROM `order_list` where rider_id <= 0 ";

	$sql = mysqli_query($conn, $query);

	while($row = mysqli_fetch_array($sql))
	{
		date_default_timezone_set('Asia/Kolkata');

		$oid = $row['id'];
		$cdate = date('Y-m-d');
		$ctime = date('H:i');
		$vdate = $row['vdate'];
		

      	if($cdate == $vdate)
      	{
      		
      			$query2 = "SELECT *,riders.id as rid FROM `rider` inner join riders on rider.rider_code=riders.rider_code where rider.assign_job='false' ";
				$sql2 = mysqli_query($conn, $query2);
				
				while($r2 = mysqli_fetch_array($sql2))
				{
					// print_r($r2);die;
					$q3 = "SELECT * FROM `order_list` where rider_id <= 0";
					$sql3 = mysqli_query($conn, $q3);
					while($r3 = mysqli_fetch_array($sql3))
					{
					
					if($r3['rider_id'] <= 0)
					{
						$rider_id = $r2['rid'];
						$rider_mobile_no = $r2['rider_mobile_no'];
						$post_date =Date("Y-m-d h:i");
						$up="UPDATE `order_list` SET `rider_id` = '$rider_id',`rider_alert`='y',`rider_info`='$rider_mobile_no',`rider_alot_time`='$post_date',`w_status`=0 WHERE `order_list`.`id` ='$oid'";
							mysqli_query($conn,$up);
					}

					}
				}
			
      	}
	}
	
?>