

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Registeration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    

<!-- Modal for register  -->
<div class="modal fade" id="adminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register Here</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="regCode.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" required="required" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">NRIC NO.</label>
                <input type="text" required="required" name="nric" class="form-control">
                <br/>
                <label for="file">NRIC ID</label>
                <input type="file" required="required" name="image" ><?php echo @$row['nric_image']; ?>
            </div>
            <div class="form-group">
                <label for="">Address</label>
                <textarea name="address" required="required" rols="10" cols="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="">Which area to work ?</label><br>
                <select required class="form-control" name="work_area" id="">
                    <option value="">--Select-area--</option>
                    <option value="india">INDIA</option>
                    <option value="italy">ITALY</option>
                    <option value="us">US</option>
                </select>
            </div>


            <div class="form-group">
                <label for="">Job Type</label><br/>
                <input type="radio"  checked name="job_type" value="full time" class="">Full Time
                <input type="radio" name="job_type" value="part time" class="">Part Time
            </div>

            <div class="form-group">
                <label for="">Date</label>
                <input class="form-control" required="required" type="date" name="date" class="">
                <label for="">Time</label>
                <input class="form-control" required="required" type="time" name="time" class="">
            </div>

            <div class="form-group">
                <label for="">What transport to work ?</label><br/>
                <input type="radio" checked name="transport" value="car" class="">Car
                <input type="radio" name="transport" value="motorcycle" class="">MotorCycle
                <input type="radio" name="transport" value="lorry" class="">Lorry
            </div>

            
            <div class="form-group">
                <label for="">What service can you provide? </label><br/>
                <input type="radio" checked name="service" value="man power" class="">Man power
                <input type="radio" name="service" value="car" class="">Car
                <input type="radio" name="service" value="motorcycle" class="">MotorCycle
                <input type="radio" name="service" value="lorry" class="">Lorry
            </div>
            <div class="form-group">
                <label for="">Rider Code</label>
                <input type="text" required="required" name="r_code" class="form-control">
            </div>
           

            <input type="hidden" name="usertype" value="admin">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Register</button>
         </div>
      </form>
      
      
    </div>
  </div>
</div>



<!-- Modal for Login  -->
<div class="modal fade" id="loginhere" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login Here</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="logincode.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" required="required" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">NRIC NO.</label>
                <input type="text" required="required" name="nric" class="form-control">
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="loginbtn" class="btn btn-primary">Login</button>
         </div>
      </form>
      
      
    </div>
  </div>
</div>




    <div class="container-fluid">

        <!-- <div class="card shadow mb-4"> -->

            <div class="card-header py-3">
                <h6 class="font-weight-bold m-0 text-primary">Register as Rider
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adminprofile"> Register
                </button>
                </h6>
            </div>

            <br/>

            <div class="card-header py-3">
                <h6 class="font-weight-bold m-0 text-primary">Login as Rider
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginhere"> Login
                </button>
                </h6>
            </div>

    </div>


<!-- here the content -->





<!-- scripts  -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        </body>
</html>

