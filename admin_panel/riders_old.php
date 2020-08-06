<?php 
include("config.php");

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
