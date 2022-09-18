<?php

session_start();

if(isset($_SESSION['login']))
{
  if($_SESSION['login'] === 'Successful')
  {
      $_SESSION['login'] = "Successful";
      $conn = mysqli_connect("localhost","root","","cyber_asnmt");
include('../../includes/webinars/header.php');
include('../../includes/webinars/sidebar.php');
include('../../includes/webinars/navbar.php');  

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="text-center">
            <h1>Event Details</h1>
            <h6><small class="text-muted"> View the details of the events here. </small></h6>
        </div><br/><br/>
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $query = "SELECT * FROM event_details";
                                $query_run = mysqli_query($conn, $query);
                                if(mysqli_num_rows($query_run)){
                                    while($row=mysqli_fetch_assoc($query_run))
                                    {
                            ?>
                            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                <div class="text-md-center text-xl-left">
                                    <h2 class="mb-1"><?=$row['name'] ?></h2>
                                    <h4 class="mb-1"><?=$row['event_type'] ?></h4>
                                        <h5 class="mb-0">Organizer : &nbsp;&nbsp;<?=$row['organizer_name'] ?></h5>
                                            <p class="mb-0 mt-2">Dated: <label class="text-success font-weight-medium"><?=$row['dated'] ?></label></p>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                                else{
                                        echo 'No Data Found';
                                }
                                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
<?php
include('../../includes/webinars/script.php');
include('../../includes/webinars/footer.php');
    }
}
else
{
  echo "<script>
          alert('You have been logged out. Please login again to continue');
          window.location.href='../../index.php';
        </script>";
}
?>