<?php
include("config.php");
function ceiling($number, $significance = 1)
								{
									return ( is_numeric($number) && is_numeric($significance) ) ? (ceil(round($number/$significance))*$significance) : false;
								}
$s_id=$_GET['s_id'];
// $s_id=22657;
if($s_id)
{
	$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT order_list.*,users.name,users.isLocked,users.otp_verified,users.mobile_number 
	FROM order_list inner join users on order_list.user_id=users.id WHERE order_list.id='".$s_id."'"));
	
	$m_id=$row['merchant_id'];
	$merchant_name=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$m_id."'"));
	$sstper=$merchant_name['sst_rate'];
	if($row)
	{
		$product_ids = explode(",",$row['product_id']);
		$quantity_ids = explode(",",$row['quantity']);
		$amount_val = explode(",",$row['amount']);
		$product_code = explode(",",$row['product_code']);
		$amount_data = array_combine($product_ids, $amount_val);
		$total_data = array_combine($quantity_ids, $amount_val);
		 $remark_ids = explode("|",str_replace("_", " ", $row['remark']));
		// echo "Product Name </br>";
		$i=0;
		 $varient_type=$row['varient_type'];
			if($varient_type)
			{
				$v_str=$row['varient_type'];
				$v_array=explode("|",$v_str);
			}
		$total_qun=0;
		foreach ($amount_val as $key => $value){
                            if( $quantity_ids[$key] && $value ) {
                                $total =  $total + ($quantity_ids[$key] *$value );
								$total_qun+=$quantity_ids[$key];
                            } 
                           }
						 if($sstper>0){
							$incsst = ($sstper / 100) * $total;
							    $incsst=@number_format($incsst, 2);
								$incsst=ceiling($incsst,0.05);
								  $incsst=@number_format($incsst, 2);
							     $g_total=@number_format($total+$incsst, 2);
								} else { $g_total=$total;} 
		$total_bill=($g_total+$row['order_extra_charge']+$row['deliver_tax_amount']+$row['special_delivery_amount'])-($row['wallet_paid_amount']+$row['membership_discount']+$row['coupon_discount']);
		$r_str='';
		$show_remark='';
		$o_remark='';
		$c_remark='';
		$msg_str='';
		$date=$row['created_on'];
		
		$msg_str.="Date :".date("d/m/Y h:i A",strtotime($date));
		$special_delivery_amount=$row['special_delivery_amount'];
		if($row['remark_extra'])
		{
			$msg_str.="</br>Order Remark:".$row['remark_extra'];
		}
		if($row['plastic_box'])
		{
			$msg_str.="</br>Container:".$row['plastic_box'];  
		}
		$v_comisssion=$row['vendor_comission'];
		$v_comisssion=number_format($v_comisssion,2);
		if($v_comisssion)
		{
			if($special_delivery_amount)
			$msg_str.="<br/>Cash term Pay:(".$total."+(chinese man delivery))-".$v_comisssion."(com)=".number_format($total-$v_comisssion,2);
			else
			$msg_str.="<br/>Cash term Pay:".$total."-".$v_comisssion."(com)=".number_format($total-$v_comisssion,2);
		}
		else
		{
			if($special_delivery_amount)
			$msg_str.="<br/>Cash term Pay:".number_format($total,2)."+".number_format($special_delivery_amount,2)."(chinese man delivery)";
			else
			$msg_str.="<br/>Cash term Pay:".number_format($total,2);	  
		}
		 $otp_str='';
		if($row['otp_verified']=="n")
		$otp_str="(Unverified)";
		else if($row['isLocked']==1)
		{
			$otp_str="(Locked)";
		}
		if($row['invoice_no'])
		{
			$inv_str="(".$row['wallet'].")"." Invoice No: ".$row['invoice_no'];
		}
		if($row['location'])
		{
			$user_location="</br>".$row['location'];
		}
		$wallet=$row['wallet'];
		if($row['coupon_discount']=='')
			$row['coupon_discount']=0;
		if($row['special_delivery_amount']==0)
		$msg_str.="</br>Collect:{".$total."+".$incsst."(SST)+".$row['order_extra_charge']."+".$row['deliver_tax_amount'].")-(".$row['wallet_paid_amount']."(WALLET)-".$row['membership_discount']."-".$row['coupon_discount']."}=".number_format($total_bill,2)."</br>".$inv_str."</br>Pickup Type:".$row['pickup_type']."</br>Order from:</br>".$merchant_name['name'].",</br>".$merchant_name['google_map']." ,</br> Mobile - ".$merchant_name['mobile_number']." <br/>  To: ".$row['user_name']." </br>,".$row['user_mobile'].$otp_str."".$user_location."</br> Order Detail:</br>";
		else
		$msg_str.="</br>Collect:{".$total."+".$incsst."(SST)+".$row['order_extra_charge']."+".$row['deliver_tax_amount']."+".$row['special_delivery_amount'].")-(".$row['wallet_paid_amount']."(WALLET)-".$row['membership_discount']."-".$row['coupon_discount']."}=".number_format($total_bill,2)."</br>".$inv_str."</br>Pickup Type:".$row['pickup_type']."</br> Order from:</b>".$merchant_name['name'].",</br>".$merchant_name['google_map']." ,</br> Mobile - ".$merchant_name['mobile_number']." <br/>  To: ".$row['user_name']." </br>,".$row['user_mobile'].$otp_str."".$user_location."</br> Order Detail:</br>";
	
		foreach ($product_ids as $key )
        {  
			if(is_numeric($key))
            {
                $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$key."'"));
				// $msg_str.="<b>".$product['product_name'].',qty-'.$quantity_ids[$i].',Unit Price '.$product['product_price'].'</b><br>';
				$msg_str.="<b>".$product['product_name']."(".$product['category'].')('.$product['product_type'].'),qty-'.$quantity_ids[$i].',Unit Price:'.$product['product_price'].'</b></br>';    
			}
			else
			{
               $msg_str.=$key.'<br>';
			}
			if($remark_ids[$i])
			{
				$msg_str.= "Remark :".$remark_ids[$i].'<br>';
			}
			if($v_array[$i])
			{
				$v_match=$v_array[$i];
				$v_match = ltrim($v_match, ',');
				$sub_rows = mysqli_query($conn, "SELECT * FROM sub_products WHERE id  in ($v_match)");
				while ($srow=mysqli_fetch_assoc($sub_rows)){
					$msg_str.=  "&nbsp;&nbsp;&nbsp;&nbsp;"."-".$srow['name'].",Price:".number_format($srow['product_price'],2);
					$msg_str.=  "</br>";
					}
			}
		   
			$i++;
		}
		$msg_str.="Total qty : ".$total_qun."</br>";
		
		echo $msg_str;   
	}
}
?>