<?php 
include('config.php');
if(empty($_GET['ms']))
{
	$sid=$_GET['sid'];
	$url="showorder.php?sid=".$sid."&ms=".md5(rand());

header("Location:$url");
exit();
}

//current time
date_default_timezone_set('Asia/Kolkata');

$assign_time = date('H:i:s');
// echo $assign_time."<br>";


$endTime = strtotime("+1 hour", strtotime($assign_time)); // 4mints added to databse time
$n_time= date('H:i:s', $endTime);
// echo $n_time;

//

if (empty($_SESSION["langfile"])) { $_SESSION["langfile"] = "english"; }
    require_once ("languages/".$_SESSION["langfile"].".php");
$query="SELECT order_list.*,u.name as merchant_name,u.mobile_number as merchant_mobile_number from order_list inner join 
users as u on u.id=order_list.merchant_id WHERE vtime<='$n_time' && vdate<=CURDATE()  order by order_list.id desc limit 0,100  ";
$current_time = date('Y-m-d H:i:s');
function ceiling($number, $significance = 1)
{
	return ( is_numeric($number) && is_numeric($significance) ) ? (ceil(round($number/$significance))*$significance) : false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Latest order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/font-awesome.min.css">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Latest Order</h2>
          
  <table class="table">
    <thead>
      <tr>
        <th>S.No</th>
        <th>DATE OF ORDER</th>
        <th>Detail</th>
        <th>Write up</th>
      
        <th>User Detail</th>
        <th>Merchant Name</th>
        <th>Merchant Mobile Number</th>
        <th>Order Status</th>

        <th>Action</th>
		          <th>Rider Info</th>
      </tr>
    </thead>
    <tbody>
	<?php 
     $qu=mysqli_query($conn,$query);
	 $i=1;
	 while($r=mysqli_fetch_array($qu))
	 {
		   $created =$row['created_on'];
		 $date=date_create($created);
		 $row=$r;
		        if($r['status'] == 0)
								{
									$sta =$language['pending'];
									$s_color="red";
									$n_status=1;
								}
                                else if($r['status'] == 1) 
								{
									
									$sta =$language['done_in_delivery'];
									$s_color="green";
									$n_status=4;
								}
								else if($r['status'] == 4 || $r['status']==5) 
								{
									$sta =$language['done_in_delivery'];
									$s_color="green";
								}
                                else 
								{
									$n_status=1;
									$sta =$language['accepted'];
									// $sta = "Accepted";
									$s_color="";
								}
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
	?>
      <tr>
        <td><?php echo $i; ?></td>
		                            <td><?php echo date_format($date,"m/d/Y");  ?>
                                <?php echo '<br>'; echo $new_time[1] ?>
                                <?php 
                                  if($row['status'] == 0 ){?>
<script>
var timeleft = 90;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    document.getElementById("<?=$row['product_id']?>").innerHTML = "Finished";
  } else {
    document.getElementById("<?=$row['product_id']?>").innerHTML = timeleft + " seconds";
  }
  timeleft--;

  $.ajax({
			url: "update_timer.php",
			type: "POST",
			cache: false,
			data:{
				id: $('#p<?=$row['product_id']?>').val(),
				time: timeleft,
			},
			success: function(dataResult){
				// alert(dataResult);
			}
		});

}, 1000);
</script>		<input type="hidden" value="<?=$row['product_id']?>" id="p<?=$row['product_id']?>" >		
				<p style="color: red;" id="<?=$row['product_id']?>" >
								</p>
								<p style="color: red;" id="<?=$row['product_id']?>" >

								</p>

								<?php 
                                  }?>
                            </td>
		<td  style="font-size:18px;" class="s_order_detail btn btn-blue" total_bill="<?php echo number_format($total_bill,2); ?>" order_id='<?php echo $row['id']; ?>'><?php echo $language['detail']; ?></td>
        	<td class="writeup_set" id="writeup_set_<?php  echo $row['id'];?>" order_id='<?php echo $row['id']; ?>'><i class="fa fa-copy" style="font-size:25px;margin-left: 10%;"></i></td>
		<td>
		<?php if($r['user_name']){  echo $r['user_name']."- ".$r['user_mobile']; } else { echo $r['user_mobile'];} ?>
		</td>
		<td><?php echo $r['merchant_name']; ?></td>
        <td><?php echo $r['merchant_mobile_number']; ?></td>
        <td><input type="button" next_status="<?php echo $n_status; ?>" style="background-color:<?php echo $s_color;?>" class= "status btn btn-primary" value="<?php  echo $sta;?>" status="<?php echo $row['status'];?>" data-invoce='<?php echo $row['invoice_no'];?>' data-id="<?php echo $row['id']; ?>"/>

</td>

<td><a target="_blank" href="orderview.php?did=<?php echo $row['merchant_id'];?>&vs=<?php  echo md5(rand());?>">Check order</a></td>
<td><?php echo $row['rider_info']; ?></td>
      </tr>
	 <?php $i++;} ?>
      
    </tbody>
  </table>
</div>
<div class="modal fade" id="orderdetailmodel" role="dialog" style="margin-top:12%;"> 
							<div class="modal-dialog">
							<!-- Modal content-->		
							<div class="modal-content" style="min-height:350px;">	
							<div class="modal-header">	
							<button type="button" class="close" data-dismiss="modal">&times;</button>						
							<h4 class="modal-title">Order Detail</h4>	
							</div>					
							<form id ="orderdetailform">		
							<div class="modal-body" style="padding-bottom:0px;">
							<div class="col-sm-10" id="orderdata">		  				
											
							</div>						
												
							</form>						
							</div>						
							</div>						
							</div>
						</div>
<script>
function generatetokenno(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
$(document).ready(function(){
	$(".writeup_set").click(function(e){
		  var s_id = $(this).attr('order_id');
		  var input_id="writeup_set_"+s_id;
		  $.ajax({
                        type: "POST",
                        url: "writeupshow.php",
                        data: {s_id:s_id},
                        success: function(data) {
							// alert(data);
							// $(this).text(data);
							document.getElementById(input_id).innerHTML =data;
							// $('#write_up_input').val(data);
							 // var copyText = document.getElementById("write_up_input");
							  // copyText.select();
							  // copyText.setSelectionRange(0, 99999)
							  // document.execCommand("copy");
							  // alert("Copied the text: " + copyText.value);
                        },
                        error: function(result) {
                            alert('error');
                        }
                });
		  // $("#orderdetailmodel").modal("show"); 
	  });
	 $(".s_order_detail").click(function(e){
		  var s_id = $(this).attr('order_id');
		  var total_bill = $(this).attr('total_bill');
		  $.ajax({
                        type: "POST",
                        url: "singleorder.php",
                        data: {s_id:s_id,total_bill:total_bill},
                        success: function(data) {
							$('#orderdata').html(data);
                        },
                        error: function(result) {
                            alert('error');
                        }
                });
		  $("#orderdetailmodel").modal("show"); 
	  });
	  
	  	    setInterval(function(){ 
				
					var s_token=generatetokenno(16);
						var r_url="https://localhost/koolive/showorder.php?ms="+s_token;
					 window.location.replace(r_url);
			}, 
				60000);      
	   
});

</script>
</body>

</html>
