<?php 
    include 'config.php';

    $time = $_POST['time'];
    $pid = $_POST['id'];

    // echo $pid;

    $sql = "UPDATE `order_list` SET timer='$time' where `product_id`='$pid'";
    
?>