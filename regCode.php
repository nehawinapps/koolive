<?php
    include('config.php');

    session_start();
// INSERT data
    // $conn = mysqli_connect("localhost","root","","adminpanel");

    if(isset($_POST['registerbtn']))
    {
        @$name = $_POST['name'];
        @$r_code = $_POST['r_code'];
        @$nric = $_POST['nric'];
       // @$_SESSION['nric_reg']=$nric;
        @$address = $_POST['address'];
        @$work_area =$_POST['work_area'];
        @$job_type = $_POST['job_type'];
        @$date = $_POST['date'];
        @$time = $_POST['time'];
        @$transport = $_POST['transport'];
        @$service = $_POST['service'];
       // @$trips = $_POST['trips'];
        @$image = $_FILES['image']['name'];
        @$image_loc = $_FILES['image']['tmp_name'];

        $image_store="nric/".$image;


        //echo $work_area;
        // if($password===$confirmpassword)
        // {
            move_uploaded_file($image_loc,$image_store);

            $query = "INSERT INTO rider (name,nric,address,work_area,job_type,date,time,transport,service,nric_image,rider_code) 
            VALUES ('$name','$nric','$address','$work_area','$job_type','$date','$time','$transport','$service','$image','$r_code')";

            $query_run = mysqli_query($conn,$query);
        

            if($query_run)
            {
                $_SESSION['success'] = "Rider Profile Added";
                header('Location:register.php');
            }
            else
            {
                $_SESSION['status'] = "Rider Profile Not Added";
                header('Location:register.php');
            }
       // }
        // else
        // {
        //     $_SESSION['status'] = "Password Doesn't match";
        //     //header('Location: register.php');
        // }

    }

// UPDATE data
    if (isset($_POST['updatebtn'])) 
    {
        @$name = $_POST['name'];
        @$nric = $_POST['nric'];
        @$address = $_POST['address'];
        @$work_area =$_POST['work_area'];
        @$job_type = $_POST['job_type'];
        @$date = $_POST['date'];
        @$time = $_POST['time'];
        @$transport = $_POST['transport'];
        @$service = $_POST['service'];
        //@$trips = $_POST['trips'];
        @$id = $_POST['edit_id'];
        @$image = $_FILES['image']['name'];
        @$image_loc = $_FILES['image']['tmp_name'];

        $image_store="nric/".$image;


        $query = "UPDATE rider SET name='$name', nric='$nric', address='$address', work_area='$work_area', job_type='$job_type',
        
         date='$date',time='$time',transport='$transport',service='$service',nric_image='$image'    WHERE Id=$id";
        $query_run = mysqli_query($conn,$query);

        if ($query_run) 
        {
            $_SESSION['success'] = "Admin details are Updated";
            header('Location: register.php');
        }
        else
        {
            $_SESSION['status'] = "Details are not Updated";
            header('Location: register.php');
        }
    }

// DELETE data
    if (isset($_POST['deletebtn'])) 
    {
        $id = $_POST['delete_id'];

        $query = "DELETE FROM rider WHERE id='$id' ";
        $query_run = mysqli_query($conn,$query);

        if ($query_run) 
        {
            $_SESSION['success'] = "Admin is deleted";
            header('Location: register.php');
        }
        else
        {
            $_SESSION['status'] = "Admin is not deleted";
            header('Location: register.php');
        }
    }

// Login 
   
    

?>