<?php 
include("config.php");





if(!isset($_SESSION['admin']))
{
	header("location:login.php");
}
$rec_limit = 500;

/* end  for limit  */

 $sql = "select count(id) as total_count from users Where user_roles = 2";

$row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
$rec_limit = 500;
  $rec_count = $row['total_count'];

if( isset($_GET{'page'} ) ) {
            $page = $_GET{'page'};
            $offset = $rec_limit * $page ;
         }else {
            $page = 0;
            $offset = 0;
         }
         
$left_rec = $rec_count - ($page * $rec_limit);
     $query="select SQL_NO_CACHE * from users Where user_roles = 2 order by name desc LIMIT $offset, $rec_limit";

$user = mysqli_query($conn,$query);
$total_rows = mysqli_num_rows($user);
$total_page_num = ceil($total_rows / $limit);

$start = ($page - 1) * $limit;
$end = $page * $limit;
$a_m="merchant";
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
					<h2 class="text-center wallet_h">Merchant List</h2>
					<button type="button" class="btn btn-danger" onclick="window.location.href='./merchant.php'">Clear Page</button>
					<button type="button" class="btn btn-danger" onclick="window.location.href='./addmerchant.php'">Add Merchant</button>
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
							<th>Particular</th>
							<th>Name</th>
							<th>Mobile Nmber</th>
							<th>K Type</th>
							<th>Wallet Coin</th>
							<th>MYR Wallet</th>
							<th>CF</th>
							<th>Joining Date</th>
							<th>Nature of Business</th>
							<th>Whatapp Group Name</th>
							<th>Status</th>
							<th>Merchant Status</th>
							<th>Set Delivery Rate (%) </th>
							<th>Vendor Comission (%) </th>
							<th>Chiness Delivery </th>
							<th>Price Hike </th>
							<th> Time of the pop-up </th>
							<th>Popular Merchant </th>
							<th>Show Merchant </th>
							
							<!--th>Delivery Rate use </th!-->
							<th>View</th>
							<th>Delete</th>
						  </tr>
					    </thead>
					   <tbody>
                    	<?php
                    	$i=1;
                    	while($row=mysqli_fetch_assoc($user)){
							 ?>
                        	  <tr>
                        		 <td> <?php echo $i; ?> </td>
                                <td class="name" data-id=<?php echo $row['id']; ?> style="cursor:pointer;"><?php echo $row['name'];  ?></td>
                                <td><?php echo $row['mobile_number'];  ?></td>
                                <td><?php echo $row['account_type'];?></td>
                        		<td><?php echo $row['balance_usd'];  ?></td>
                        		<td><?php echo $row['balance_myr'];  ?></td>
                        		<td><?php echo $row['balance_inr'];  ?></td>
                        		<td><?php  $date=$row['joined'];
                        	        echo $joinigdate=date("Y-m-d h:i:sa",$date);  ?>
                        	    </td>
                        	    <td>
                        	    	<select class='service' name="service" style="">
											<option>Select Nature of Business</option>
											<?php
												$sql = mysqli_query($conn, "SELECT * FROM service WHERE status=1");
	                                           	$selected = '';
	                                           	while($data = mysqli_fetch_array($sql))
	                                           	{
	                                           		if($data['id'] == $row['service_id']){
	                                           			$selected= 'selected';
	                                           		}else{
	                                           			$selected = '';
	                                           		}
	                                           	 	echo'<option data-id="'.$row['id'].'" value="'.$data['id'].'" '.$selected.'>'.$data['short_name'].'</option>';
	                                           	}

											?>
                                        </select>

                        	    </td>
								<td><input type="text" class="grup_save" data_id="<?php echo $row['id']; ?>" value="<?php echo $row['whatapp_group_name'];?>" class="form-control"/></td>
								
                        	    <td>
                        	        <select class='status' data-id="<?php echo $row['id']; ?>" >
                                	    <option>Select Status</option>
                                	    <option value='1' <?php echo $row['isLocked']=='1' ? 'selected' : ''?>>Blocked</option>
                                	    <option value='0' <?php echo $row['isLocked']=='0' ? 'selected' : ''?>>Unblocked</option>
                        	        </select>
                        	    </td>
								  <td>
                        	        <select class='show_business' data-id="<?php echo $row['id']; ?>" >
                                	    <option>Merchant Status</option>
                                	    <option value='1' <?php echo $row['show_business']=='1' ? 'selected' : ''?>>Show</option>
                                	    <option value='0' <?php echo $row['show_business']=='0' ? 'selected' : ''?>>Hide</option>
                        	        </select>
                        	    </td>
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="delivery_rate" placeholder="%" class="form-control delivery_rate" value="<?php echo $row['delivery_rate'];?>"></td>   
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="vendor_comission" placeholder="%" class="form-control vendor_comission" value="<?php echo $row['vendor_comission'];?>"></td>   
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="special_price_value" placeholder="" class="form-control special_price_value" value="<?php echo $row['special_price_value'];?>"></td>   
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="price_hike" placeholder="" class="form-control price_hike" value="<?php echo $row['price_hike'];?>"></td>   
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="custom_msg_time" placeholder="" class="form-control custom_msg_time" value="<?php echo $row['custom_msg_time'];?>"></td>   
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="popular_restro" placeholder="" class="form-control popular_restro" value="<?php echo $row['popular_restro'];?>"></td>   
								<td><input type="text" selected_user_id="<?php echo $row['id']; ?>"  name="show_merchant" placeholder="" class="form-control show_merchant" value="<?php echo $row['show_merchant'];?>"></td>   
								<!--td>
									<div class="form-group checkbox-checked">
											
											<input type="checkbox" class="delivery_select" selected_user_id="<?php echo $row['id']; ?>" selected_type="delivery_take_up" name="delivery_take_up" <?php if($row['delivery_take_up'] == '1') echo "checked='checked'";?>> Take away<br>
											<input type="checkbox" class="delivery_select" selected_user_id="<?php echo $row['id']; ?>" selected_type="delivery_dive_in" name="delivery_dive_in" <?php if($row['delivery_take_up'] == '1') echo "checked='checked'";?>> Dine in<br>
   
									</div>
								</td!-->
                        	    <td><a href="user_edit.php?id=<?php echo $row['id'];?>"><i style="font-size: 20px;" class="fa fa-eye"></i></a></td>
                                <td class="del" data-toggle="modal" data-target="#delModal" data-del="<?php echo $row['id']; ?>"><i style="font-size: 20px;" class="fa fa-trash"></i></td>
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
				
	$(".status").change(function(){
		var status = $(this).val();
		//~ alert(status);
		var id = $(this).data("id");
		//~ alert(id);
		$.ajax({
			url : 'updateuser.php',
			type: 'POST',
			data :{updatedid:id,upadtedstatus:status},
			success:function(data){
		     location.reload();
			}  
		});
		
	});
	$(".show_business").change(function(){
		var status = $(this).val();
		//~ alert(status);
		var id = $(this).data("id");
		//~ alert(id);
		$.ajax({
			url : 'updateuser.php',
			type: 'POST',
			data :{m_id:id,upadtedstatus:status},
			success:function(data){  
				location.reload();
			}
		});
		
	});
    		$(".grup_save").focusout(function(e){
		var selected_user_id= $(this).attr('data_id');
		var whatapp_group_name=this.value;
		if(whatapp_group_name!='' && selected_user_id)
		{  
		  $.ajax({
						url :'updatenatureofbusiness.php',
						 type:"post",
						 data:{updatedid:selected_user_id,whatapp_group_name:whatapp_group_name},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							alert(data.msg);
						 }
				});      
		} 
	});
	$(".service").change(function(){
		var service_id = $(this).val();
		 //alert(service_id);
		 var id = $(this).find(':selected').attr('data-id');
		 //alert(id);
		$.ajax({
			url : 'updatenatureofbusiness.php',
			type: 'POST',
			data :{updatedid:id,service_id:service_id},
			success:function(data){
		
			}
		});
		
	});

	$(".delivery_rate").focusout(function(e){
		var selected_user_id= $(this).attr('selected_user_id');
		var delivery_rate=this.value;
		if(delivery_rate!='' && selected_user_id)
		{  
		  $.ajax({
						url :'../functions.php',
						 type:"post",
						 data:{delivery_rate:delivery_rate,method:"adminprofilesave",selected_user_id:selected_user_id},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							if(data.status==true)
							{
							  // location.reload(true);
								
							}
							else
							{alert('Failed to update');	}
							
							}
				});      
		} 
	});
		$(".vendor_comission").focusout(function(e){
		var selected_user_id= $(this).attr('selected_user_id');
		var vendor_comission=this.value;
		if(vendor_comission!='' && selected_user_id)
		{  
		  $.ajax({
						url :'../functions.php',
						 type:"post",
						 data:{vendor_comission:vendor_comission,method:"adminprofilesave",selected_user_id:selected_user_id},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							if(data.status==true)
							{
							  // location.reload(true);
							alert('Updated');
							}
							else
							{alert('Failed to update');	}
							
							}
				});      
		} 
	});
	$(".special_price_value").focusout(function(e){
		var selected_user_id= $(this).attr('selected_user_id');
		var special_price_value=this.value;
		if(special_price_value!='' && selected_user_id)
		{  
		  $.ajax({
						url :'../functions.php',
						 type:"post",
						 data:{special_price_value:special_price_value,method:"adminprofilesave",selected_user_id:selected_user_id},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							if(data.status==true)
							{
							  // location.reload(true);
								alert('Updated');
							}
							else
							{alert('Failed to update');	}
							
							}
				});      
		} 
	});
	$(".price_hike").focusout(function(e){
		var selected_user_id= $(this).attr('selected_user_id');
		var price_hike=this.value;
		if(price_hike!='' && selected_user_id)
		{  
		  $.ajax({
						url :'../functions.php',
						 type:"post",
						 data:{price_hike:price_hike,method:"adminprofilesave",selected_user_id:selected_user_id},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							if(data.status==true)
							{
							  // location.reload(true);
								alert('Price hike updated');
							}
							else
							{alert('Failed to update');	}
							
							}
				});      
		} 
	});
	$(".popular_restro").focusout(function(e){
		var selected_user_id= $(this).attr('selected_user_id');
		var popular_restro=this.value;
		if(popular_restro!='' && selected_user_id)
		{  
		  $.ajax({
						url :'../functions.php',
						 type:"post",
						 data:{popular_restro:popular_restro,method:"adminprofilesave",selected_user_id:selected_user_id},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							if(data.status==true)
							{
							  // location.reload(true);
								alert('Status updated for popular merchant');
							}
							else
							{alert('Failed to update');	}
							
							}
				});      
		} 
	});
	$(".show_merchant").focusout(function(e){
		var selected_user_id= $(this).attr('selected_user_id');
		var show_merchant=this.value;
		if(show_merchant!='' && selected_user_id)
		{  
		  $.ajax({
						url :'../functions.php',
						 type:"post",
						 data:{show_merchant:show_merchant,method:"adminprofilesave",selected_user_id:selected_user_id},     
						 dataType:'json',
						 success:function(result){  
							var data = JSON.parse(JSON.stringify(result));   
							if(data.status==true)
							{
							  // location.reload(true);
								alert('Status updated for show merchant');
							}
							else
							{alert('Failed to update');	}
							
							}
				});      
		} 
	});  
	
	$('.delivery_select').change(function() {
		var selected_type= $(this).attr('selected_type');
		alert(selected_type);
        if($(this).is(":checked")) {
            
        }
	});
  $(".name").click(function(){
	  $("#myModal").modal("show");
	  var userid=$(this).data("id");
	 
	  $.ajax({
		  
		  url :'bankdatalil.php',
		  type:'POST',
		  data:{showid:userid},
		  success:function(table){
			 $("#modalcontent").html(table);
		  }		  
	  });
	 
  });
	
	/*user delete function */
	
	$('.del').click(function(){
        var id=$(this).data("del");
        
        $(".confirm-btn").attr({'user-id': id});
    });
    $('.confirm-btn').click(function(){
        var id = $(this).attr('user-id');
        $.ajax({
            url:'user_delete.php',
            type:'POST',
            data:{id:id},
            success: function(data) {
                location.reload();
            }
        });
    });
				
				
	});
	  
	  
	</script>
	
</body>

</html>
