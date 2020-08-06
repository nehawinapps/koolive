<?php 
include("config.php");

if(!isset($_SESSION['login']))
{
	header("location:login.php");
}
$bank_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'"));

 $current_id = $bank_data['id'];
  $current_uid = $_SESSION['login'];
  if(isset($_POST['not_working']))
{
    $not_working_text=$_POST['not_working_text'];
    $not_working_text_chiness=$_POST['not_working_text_chiness'];
  
  
   if($not_working_text || $not_working_text_chiness)
   {
	   // echo "updated users set not_working_text='$not_working_text' where id='$current_id'";
	   $update=mysqli_query($conn,"update users set not_working_text='$not_working_text',not_working_text_chiness='$not_working_text_chiness' where id='$current_id'");
	  // die; 
   }
   $send_url=$site_url."/set_workinghours.php"."?vs=".md5(rand());
		   header("Location:$send_url");
}
if(isset($_POST['submit']))
{
	if($_POST['insert']=="insert")
	{	
		$sql = "select * from timings where merchant_id =$current_uid";
		$rel = mysqli_query($conn,$sql);

		if (mysqli_num_rows($rel) >= 0) {
			/*echo"<script>alert('Working Hours already set,you have only edit or delete');</script>";
	  	  
	  	}else{*/
          
		$day = addslashes($_POST['day']);
	
		$start_time = addslashes($_POST['start_time']);
		$end_time = addslashes($_POST['end_time']);
		
	  	 $insert_test  = mysqli_query($conn, "INSERT INTO timings SET merchant_id='$current_uid',day='$day',start_time='$start_time',end_time='$end_time'");
	  	 if($insert_test)
		{
			$error = "Data Inserted Successfully.";
			echo"<script> setTimeout(function() {
			    $('#error').fadeOut('hide');
			}, 500);</script>";

		}else
		{
			$error = "Data Inserted Unsuccessfully.";
		} 
  	    }

	}
	// header('Location: set_workinghours.php');

}
if(isset($_GET['Delete']))
{   $del_id=$_GET['Delete'];
    
    $sql="DELETE FROM `timings` WHERE `id` ='".$del_id."'";
   
    $del_query=mysqli_query($conn,$sql);
    if($del_query)
		{
			$error = "Data Deleted Successfully.";
			echo"<script> setTimeout(function() {
			    $('#error').fadeOut('hide');
			}, 500);</script>";

		}else
		{
			$error = "Data Deleted Unsuccessfully.";
		} 
}          
?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
    <?php include("includes1/head.php"); ?>
	<style>
	.well
	{
		min-height: 20px;
		padding: 19px;
		margin-bottom: 20px;
		background-color: #fff;
		border: 1px solid #e3e3e3;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
	}
	</style>
</head>

<body class="header-light sidebar-dark sidebar-expand pace-done">

    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

    <div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <?php include("includes1/navbar.php"); ?>
        <!-- /.navbar -->
        <div class="content-wrapper">
            <!-- SIDEBAR -->
            <?php include("includes1/sidebar.php"); ?>
            <!-- /.site-sidebar -->


            <main class="main-wrapper clearfix" style="min-height: 522px;">
                <div class="row" id="main-content" style="padding-top:25px">
					<div class="container" id="error">
					<?php
						if(isset($error))
						{
							echo "<div class='alert alert-info'>".$error."</div>";
						}
					?>
					</div>
					<div class="container" >
					    <div class="row">
					        <div class="well col-md-12">
							<form  method="post" enctype="multipart/form-data">
								<div class="panel price panel-red">
									<h2>Timing / Working Hours.</h2>
									<br><br>
									
									<div  class="row col-md-12">
									<div  class="col-md-3">
									
										 <label>Day</label>
										<select required class="form-control" name="day" >
										   
											<option>Select Day</option>
											<option value="monday">Monday</option>
											<option value="tuesday">Tuesday</option>
											<option value="wednesday">Wednesday</option>
											<option value="thursday">Thursday</option>
											<option value="friday">Friday</option>
											<option value="saturday">Saturday</option>
											<option value="sunday">Sunday</option>
											
											
										</select>
									</div>

								
								
									<div class="col-md-3">
										<label>Start time</label>
										<input type="time" id="start_time" class="form-control" name="start_time" min="9:00" max="24:00" value="" required> 
									</div>
									<div class="form-group col-md-2">
										<label></label>
										<h5>To</h5>
									</div>

										<div class="col-md-3">
											<label>End time</label>
											<input type="time" id="end_time" class="form-control" name="end_time" min="9:00" max="24:00" required>
										</div>
								</div>

								
							<br>
									<input type="submit" class="btn btn-block btn-primary" name="submit" value="Submit">
								</div>
								<input type="hidden" name="insert" value="insert">
							</form>
						</div>
						
					</div>
				</div>

					<div class="container" >
					    <div class="row">
					        <div class="well col-md-12">
					        	<table class="table table-striped">
									        <thead>
                                                <tr>
                                                    <th>Day</th>
                                                           
                                                    <th>Start time</th>                    
                                                    <th>End time</th> 
                                                    <th>Action</th>    
                                              </tr>
                                           </thead>
                                           <tbody > 
                                           	<?php 
                                           	$sql = mysqli_query($conn, "SELECT * FROM timings WHERE merchant_id='".$current_uid."'");
                                           	
                                           	while($data = mysqli_fetch_array($sql))
                                           	 {
                                           
                                           	 	echo'<tr><td>'.ucfirst($data['day']).'</td>
                                           	 	
                                           		<td>'.date("g:i A", strtotime($data['start_time'])).'</td>
                                           		<td>'.date("g:i A", strtotime($data['end_time'])).'</td>
                                           	
                                           		<td><a href="edit_timings.php?Edit='.$data['id'].'" id="'.$data['id'].'" class="trash" style="margin-right:5%">Edit</a><a href="newtimings.php?Delete='.$data['id'].'" class="trash">Delete</a></td></tr>';
                                           	
                                              }

                                           	?>
                                          
                                         	</tbody>
                                         	
									    </table>

					        </div>
					      </div>
					 </div> 
											<div class="container" >
					    <div class="row">
					        <div class="well col-md-12">
							<form  method="post">
								<div class="panel price panel-red">
									<h2>Not  Working Time</h2>
									<div  class="row col-md-12">
									<div  class="col-md-5">
									
										<input type="text" class="form-control" value="<?php echo $bank_data['not_working_text']; ?>" name="not_working_text" placeholder="Updated text for Not Working Hours"/>
									</div>
									<div  class="col-md-5">
									
										<input type="text" class="form-control" value="<?php echo $bank_data['not_working_text_chiness']; ?>" name="not_working_text_chiness" placeholder="Updated text for Not Working Hours in Chiness"/>
									</div>

									<div class="col-md-2">
										<input type="submit" class="btn btn-block btn-primary" name="not_working" value="Update">
									</div>

									
								</div>
								

								
							

								</div>
								
							</form>
						</div>
						
					</div>
				</div>

			</main>
        </div>

        
        <!-- /.widget-body badge -->
    </div>
    <!-- /.widget-bg -->

    <!-- /.content-wrapper -->
    <?php include("includes1/footer.php"); ?>
</body>

</html>
<script type="text/javascript">
	

function onclickFunction(aId){
    $.ajax({
        type: "get",
        url: "delete.php",
        data: {
            aId:aId
        },
        success: function (data){
            alert(data);
           
        },
       
    });
    //return false;
}

</script>
