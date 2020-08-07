<?php

include('config.php');

$query = "SELECT * FROM order_list where w_status != 0";

$sql=mysqli_query($conn,$query);

while($row = mysqli_fetch_array($sql))
{
	date_default_timezone_set("Asia/Kolkata");
	// print_r($row);
	$id = $row['id'];
	$vdate = date('Y-m-d', strtotime($row['vdate']));
	$vtime = date('H:i', strtotime($row['vtime']));


	$ttime = date('H:i', strtotime('+1 hour'));

	$tdate = date('Y-m-d');

	if($tdate == $vdate)
	{
		if($ttime == $vtime)
		{
			$que = "UPDATE order_list SET w_status='0' where id='$id' ";
			$sql = mysqli_query($conn,$que);
			// echo 'done';
		}
		else
		{
			echo 'not found';
		}
	}
	else
	{
		echo "not";
	}

}

?>