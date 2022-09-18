<?php 
session_start();

if(isset($_SESSION['login']))
{
  if($_SESSION['login'] === 'Successful')
  {
      $_SESSION['login'] = "Successful";
      include("includes/db.php");
include('includes/dashboard/header.php');
include('includes/dashboard/sidebar.php');
include('includes/dashboard/navbar.php');  

  
  
?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                        <?php 
                          $query = "SELECT * FROM event_details";
                          $query_run= mysqli_query($conn, $query);
                          if(mysqli_num_rows($query_run) > 0){
                        ?>
                            <h3 class="mb-0"><?=mysqli_num_rows($query_run) ?></h3>
                        <?php  
                          }
                          else{
                        ?>
                            <h3 class="mb-0"><?php echo '0'; ?></h3>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-message-video icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Events</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                        <?php 
                          $query = "SELECT * FROM feedback";
                          $query_run= mysqli_query($conn, $query);
                          if(mysqli_num_rows($query_run) > 0)
                          {
                        ?>
                          <h3 class="mb-0"><?=mysqli_num_rows($query_run) ?></h3>
                        <?php  
                          }
                          else{
                        ?>
                                <h3 class="mb-0"><?php echo '0'; ?></h3>
                        <?php
                          }
                        ?>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-account-multiple icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Participants</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                        <?php 
                          $query = "SELECT * FROM feedback WHERE mail_sent = 1";
                          $query_run= mysqli_query($conn, $query);
                          if(mysqli_num_rows($query_run) > 0)
                          {
                        ?>
                              <h3 class="mb-0"><?=mysqli_num_rows($query_run) ?></h3>
                        <?php  
                          }
                          else{
                        ?>
                              <h3 class="mb-0"><?php echo '0'; ?></h3>
                        <?php
                          }
                        ?>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-certificate icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Certificates Generated</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Certificate Generation History</h4>
                          <?php 
                              $query = "SELECT * FROM feedback WHERE mail_sent = 1";
                              $query_run= mysqli_query($conn, $query);
                              if(mysqli_num_rows($query_run) > 0)
                              {
                          ?>
                                   <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                      <div class="text-md-center text-xl-left">
                                        <h6 class="mb-1"><?=mysqli_num_rows($query_run)." Certificates Generated" ?></h6>
                                        <p class="text-muted mb-0">
                          <?php
                                            $query2 = "SELECT * FROM feedback WHERE mail_sent = '1' ORDER BY f_id DESC LIMIT 1";
                                            $query_run2= mysqli_query($conn, $query2);
                                            if(mysqli_num_rows($query_run) > 0)
                                            {
                                                $row = mysqli_fetch_assoc($query_run2);
                                                $evnt = $row['event_name'];
                                                $query1 = "SELECT * FROM event_details WHERE name = '$evnt'";
                                                $query_run1= mysqli_query($conn, $query1);
                                                $row1 = mysqli_fetch_assoc($query_run1);
                                                echo $row1['dated'];
                                            }
                          ?>
                                        </p>
                                      </div>
                                    </div>
                          <?php  
                              }
                          ?>
                       
                   
                          <?php 
                              $query = "SELECT * FROM event_details ORDER BY dated DESC LIMIT 1";
                              $query_run= mysqli_query($conn, $query);
                              if(mysqli_num_rows($query_run) > 0)
                              {
                                $row = mysqli_fetch_assoc($query_run);
                          ?>
                                   <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                      <div class="text-md-center text-xl-left">
                                          <h6 class="mb-1"><?='The '.$row['event_type'].' on '.$row['name']." was Added" ?></h6>
                                          <p class="text-muted mb-0">
                          <?php
                                                $query = "SELECT * FROM event_details ORDER BY dated DESC LIMIT 1";
                                                $query_run= mysqli_query($conn, $query);
                                                if(mysqli_num_rows($query_run) > 0)
                                                {
                                                  $row = mysqli_fetch_assoc($query_run);
                                                  echo $row['dated'];
                                                }
                          ?>
                                        </p>
                                    </div>
                                  </div>
                          <?php  
                              }
                          ?>
                          
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          
<?php
include('includes/dashboard/script.php');
include('includes/dashboard/footer.php');
    }
}
else
{
  echo "<script>
          alert('You have been logged out. Please login again to continue');
          window.location.href='index.php';
        </script>";
}
?>