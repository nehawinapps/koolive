<?php

    session_start();

    if (isset($_POST['logoutbtn'])) 
    {
        session_destroy();
        unset($_SESSION['rider_name']);

        header('Location: ../register.php');
    }
?>