<?php 
include("config.php");
session_start();
//$conn = mysqli_connect("localhost", "koofamil_B277", "rSFihHas];1P", "koofamil_B277");
//$conn = mysqli_connect("localhost","root","","adminpanel");

#winapps code-----------------------------------------

// $query2 = "SELECT * FROM rider";
// $query_run = mysqli_query($conn,$query2);

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query2= "SELECT * FROM rider WHERE CONCAT(`Id`, `name`, `nric`, `address`,`work_area`,`job_type`,`date`
	,`time`,`transport`,`service`,`status`,`rider_code`,`product_id`,`assign_job`) LIKE '%".$valueToSearch."%'";
	//$search_result = filterTable($query);
	$query_run = mysqli_query($conn,$query2);
    
}
 else {
    $query2 = "SELECT * FROM `rider`";
    $query_run = mysqli_query($conn,$query2);
}

// function to connect and execute the query



#winapps code ends

if(!isset($_SESSION['admin']))
{
	header("location:login.php");
}
$a_m="riders";
$rec_limit = 40;

/* end  for limit  */

 $sql = "select count(id) as total_count from jobs where view='1'";

$row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
$rec_limit = 40;
  $rec_count = $row['total_count'];

if( isset($_GET{'page'} ) ) {
            $page = $_GET{'page'};
            $offset = $rec_limit * $page ;
         }else {
            $page = 0;
            $offset = 0;
         }
         
$left_rec = $rec_count - ($page * $rec_limit);
     $query="select SQL_NO_CACHE * from riders order by id desc LIMIT $offset, $rec_limit";

$user = mysqli_query($conn,$query);
$total_rows = mysqli_num_rows($user);
$total_page_num = ceil($total_rows / $limit);

$start = ($page - 1) * $limit;
$end = $page * $limit;
// $a_m="merchant";
if(isset($_GET['jobData']) && $_GET['jobData']=="data"){
	$id = $_GET['id'];
	$res = mysqli_fetch_assoc(mysqli_query($conn,"select * from jobs where id = '$id'"));
	// print_r($res);
	echo json_encode($res);
	die();
}

if(isset($_GET['data'])&&$_GET['data']=='deleteRecord'){
	$id = $_GET['id'];
	$query = mysqli_query($conn,"UPDATE `riders` SET `status`='n' WHERE id='$id'");
	if($query){echo true;}else{die();}
}
// to change status in db
	//  $edate = $row['expire_date_utc'];
	//  $cdate = strtotime(Date("Y-m-d"));
	// if($cdate>$edate){$upQuery=mysqli_query($conn,"update jobs set status='Expired'") }
									
?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>   
    <?php include("includes1/head.php"); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="/css/dropzone.css" type="text/css" /> 
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
	#kType_table_paginate
	{
		display:none !important;
	}
	
	.wallet_h{
	    font-size: 30px;
        color: #213669;

	}
	.kType_table{
	    border: 1px #aeaeae solid !important;
	}
	.kType_table th, .kType_table td{
	    border: 1px #aeaeae solid !important;
	}
	.kType_table thead th{
	    border-bottom: 1px  #aeaeae solid !important;
	} 
	.kType_table tbody .complain{
	    color: red;
	    text-decoration: underline;
	}
	.sort{
	    margin-bottom: 10px;
	}
	/*kType_table tbody tr.k_normal{
	    background: #ececec;
	}*/
	#kType_table tbody tr.k_user{
	    background: #bcbcbc;
	}
	#kType_table tbody tr.k_merchant{
	    background: #dcdcdc;
	}
	.select2-container--bootstrap{
	    width: 175px;
	    display: inline-block !important;
	    margin-bottom: 10px;
	}
	@media  (max-width: 750px) and (min-width: 300px)  {
	    .select2-container--bootstrap{
	        width: 300px;
	    }
	}
	</style>
</head>

<body class="header-light sidebar-dark sidebar-expand pace-done">

    <div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <?php include("includes1/navbar.php"); ?>
        <!-- /.navbar -->
        <div class="content-wrapper">
            <!-- SIDEBAR -->
            <?php include("includes1/sidebar.php"); ?>
            <!-- /.site-sidebar -->


            <main class="main-wrapper clearfix" style="min-height: 522px;">
                <div class="container-fluid" id="main-content" style="padding-top:25px">
					<h2 class="text-center wallet_h">Rider List</h2>
					<!-- <button type="button" class="btn btn-danger" onclick="window.location.href='./user.php'">Clear Page</button> -->
					<button type="button" class="btn btn-danger pull-right" onclick="window.location.href='./addrider.php'">Add Rider</button>
				<h3> Total Records <?php  echo $rec_count;?></h3>
				<h4> Total Pages <?php  echo floor($rec_count/$rec_limit);?></h4>
				<?php if($rec_count>25){ ?>        
					<p style="float:right;" class="pagecount">   
					 <?php
					      
								if( $page > 0 ) {
									$last = $page - 2;
  									echo "<a href = \"$_PHP_SELF?"."page=$last\">Last $rec_limit Records</a> |";
									echo "<a href = \"$_PHP_SELF?"."page=$page\">Next $rec_limit Records</a> |";
  									
								 }else if( $page == 0 ) {
									 echo "<a href = \"$_PHP_SELF?"."page=1\">Next $rec_limit Records</a> |";
								
								 }else if( $left_rec < $rec_limit ) {
									$last = $page - 2;
									 echo "<a href = \"$_PHP_SELF?"."page=$last\">Last $rec_limit Records</a> |";
									
								 }
							?>
					</p>
					<?php } ?>
					<table class="table table-striped kType_table" id="kType_table">
					    <thead>
					        <tr>
                                <th>SR</th>
                                <th>Rider Name</th>
                                <th>Rider Code</th>
                               
                                <th>Mobile</th>
                                <th>status</th>
                               
                              
							    <th>Action</th>
						  </tr>
					    </thead>
					   <tbody>
                    	<?php
                        $i=1;
						$jobs = mysqli_query($conn, "SELECT * from riders order by id desc");
					
                    	while($row=mysqli_fetch_assoc($jobs)){
							 ?>
                        	  <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo isset($row['name'])?$row['name']:'';?></td>

                                <td><?php echo isset($row['rider_code'])?$row['rider_code']:'';?></td>
                                <td><?php echo isset($row['rider_mobile_no'])?$row['rider_mobile_no']:'';?></td>
								<td><span class="btn btn-primary"><?php if($row['status']=="y"){echo "Active";} else { echo "Inactive";} ?></span></td>
                        		 <td>
                                     <a href="javascript:void(0)" class="deleteRecord" jId="<?php echo $row['id']?>">Delete</a>
                                     <a href="editrider.php?id=<?php echo $row['id']; ?>"  >Edit</a>
                                 </td>
                              </tr>
                    	<?php
                            $i++;  
                    	}?>
                	</tbody>  
					</table>










					<?php if($rec_count>25){ ?>    
					<p style="float:right;">
					 <?php
								if( $page > 0 ) {
									$last = $page - 2;
  									echo "<a href = \"$_PHP_SELF?"."page=$last\">Last $rec_limit Records</a> |";
									echo "<a href = \"$_PHP_SELF?"."page=$page\">Next $rec_limit Records</a> |";
  									
								 }else if( $page == 0 ) {
									 echo "<a href = \"$_PHP_SELF?"."page=1\">Next $rec_limit Records</a> |";
								
								 }else if( $left_rec < $rec_limit ) {
									$last = $page - 2;
									 echo "<a href = \"$_PHP_SELF?"."page=$last\">Last $rec_limit Records</a> |";
									
								 }
							?>
					</p>
					<?php } ?>

<!-- winapps feedback-modal code -->

					<!-- Modal for Login  -->
<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Feedback To Rider</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


       <!-- <form action="" method="POST" >
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="done_btn" class="btn btn-primary">Done</button>
         </div>
      </form> -->
	        
    </div>
  </div>
</div>







				<br><br>
				<div class="table-responsive">
				<h3>Feedback To Riders</h3>
				<table class="table table-striped kType_table" id="kType_table">
					    <thead>
					        <tr>
								<th>SR</th>
								<th>NAME</th>
                                <th>NRIC</th>
                                <th>ADDRESS</th>
                                <th>LOCATION</th> 
                                <th>JOB TYPE</th> 
                                <th>DATE</th> 
                                <th>TIME</th> 
                                <th>TRANSPORT</th>
                                <th>SERVICE</th>
                                <th>RIDER CODE</th>
                                <th>STATUS
								<form action="" method="post">
									<select name="valueToSearch" id="">
										<option value="">All</option>
										<option value="true">Free</option>
										<option value="false">Not Free</option>
									</select>
									<input  class="btn btn-info" type="submit" name="search" value="Filter">
								</th>
                                <th>ON JOB</th>
								<th>FEEDBACK</th>
						  </tr>
					    </thead>
					   <tbody>
                    	<?php
                        $i=1;
					
						if (mysqli_num_rows($query_run) > 0) 
						{
							while($col = mysqli_fetch_assoc($query_run))
							{
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $col['name']; ?></td>
							<td><?php echo $col['nric']; ?></td>
							<td><?php echo $col['address']; ?></td>
							<td><?php echo $col['work_area']; ?></td>
							<td><?php echo $col['job_type']; ?></td>
							<td><?php echo $col['date']; ?></td>
							<td><?php echo $col['time']; ?></td>
							<td><?php echo $col['transport']; ?></td>
							<td><?php echo $col['service']; ?></td>
							<td><?php echo $col['rider_code']; ?></td>
							<td><span class="btn btn-primary"><?php if($col['assign_job']=="true"){echo "Free";} else { echo "Not Free";} ?></span></td>
							<td><span class="btn btn-primary"><?php if($col['status']=="y"){echo "Yes";} else { echo "No";} ?></span></td>
							
							<td >
							
						<!-- <button  type="button" data-toggle="modal" data-target="#feedback" name="feedback_btn" class="btn btn-success">Feedback</button> -->
							
								<form action="rider_feedback.php" method="POST">
                                        <input hidden type="text" name="feedback_id" value="<?php echo $col['Id']; ?>">
                                        <input hidden type="text" name="nric_id" value="<?php echo $col['nric']; ?>">
									
                                        <button type="submit" data-toggle="modal" data-target="#feedback" name="feedback_btn" class="btn btn-success">Feedback</button>
                                </form>

							</td>	
							
							
							
							</td>

						</tr>	
							<?php
                            $i++;  
						}
						
					}?>
                	</tbody>  
					</table>
				</div>
					
				
<!-- winapps- code ends -->





				</div>
			</main>
        </div>
	
        <!-- /.widget-body badge -->
    </div>
    <!-- /.widget-bg -->

    <!-- /.content-wrapper -->
	<?php include("includes1/footer.php"); ?>
	<script type="text/javascript" src="/js/dropzone.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	






	<script>
	    $(document).ready(function(){
	        jQuery(".dropzone").dropzone({
                sending : function(file, xhr, formData){
                },
                success : function(file, response) {
                    $(".complain_image").val(file.name);
                    
                }
            });
            $('#kType_table').DataTable({
				"bSort": false,
				"pageLength":1000,
				dom: 'Bfrtip',
				 buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
				});
				
	
		
	
//   $(".editJob").click(function(){
// 	  var id = $(this).attr('jId');
// 	  $.get("./jobs_list.php", {
// 		jobData: "data",
// 			id: id
// 		}, function(data){
// 			data = JSON.parse(data);
// 			console.log(data);
// 			$('#id').val(data['id']);
// 			$("#title").val(data['title']);
// 			$("#jPrice").val(data['price']);
// 			$("#jobDesc").val(data['job_desc']);
// 			$("#wGNo").val(data['whatsAppGroup']);
// 			$('#postDate').val(data['posted_date_utc']);
// 			$("#exExDate").val(data['expire_date_utc']);
// 			$("#jProname").val(data['job_provider_name']);
// 			$("#jProNo").val(data['job_provide_mobile']);
// 			$("#jobProDesc").val(data['job_provider_desc']);
			
// 			$("#category").prop("selected", false);
// 			$("#category option[value='" + data['job_category_id'] + "']").prop("selected", true);
// 			$("#edit_info").modal("show");
			

			

// 		});
		
	 
//   });
  $(".deleteRecord").click(function(){

	var id = $(this).attr('jId');
	var cnfrmDelete = confirm("Are You Sure Delete This Job ?");
	if(cnfrmDelete==true){
		  $.ajax({
				url:'riders.php',
				method:'GET',
				data:{data:'deleteRecord',id:id},
				success:function(res){location.reload(true);}
		  });	
	}
  });
	
	
				
				
	});
	  
	  
	</script>
	

	



</body>

</html>
