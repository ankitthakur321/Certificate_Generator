<?php

session_start();

if(isset($_SESSION['login']))
{
  if($_SESSION['login'] === 'Successful')
  {
      $_SESSION['login'] = "Successful";
      include('../../includes/db.php');
include('../../includes/participants/header.php');
include('../../includes/participants/sidebar.php');
include('../../includes/participants/navbar.php');  

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="text-center">
          <h1>Certificate Generation</h1>
          <h6><small class="text-muted"> Generate the certificate of below listed participants here. </small></h6>
        </div>
        <br/><br/>
        <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead>
                            <tr class="text-center">
                              <th> Name </th>
                              <th>Organisation</th>
                              <th> Email Id </th>
                              <th> Certficate Generated </th>
                            </tr>
                          </thead>
                          <?php
                            $mail_sent = null;
                            if(isset($_POST['ParticipantsList'])){
                                $wname = $_POST['web_name'];
                                $query = "SELECT * FROM feedback WHERE event_name='$wname' and mail_sent=0 ORDER BY f_id DESC LIMIT 10";
                                $query_run = mysqli_query($conn, $query);
                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    while($row=mysqli_fetch_assoc($query_run))
                                    {
                          ?>
                                  <tbody>
                                    <tr class="text-center">
                                      <td><?php echo $row['name']?></td>	
                                      <td><?php echo $row['organisation'] ?></td>
                                      <td><?php echo $row['email_id']?></td>
                                      <td><?php if($row['mail_sent'] == 0){ echo 'No'; $mail_sent = 'No';}else{ echo 'Yes'; $mail_sent = 'Yes';} ?></td>
                                    </tr>
                                  </tbody>
                          <?php 
                                }
                              }
                              else
                              {
                                echo "All the certificates has been generated for this event";
                                $_SESSION['records'] = 'Not Found';
                              }
                            }
                            mysqli_close($conn);

                          ?>
                        </table>
                      </div>
                       
                    </div>
                    <?php
                            if(isset($_POST['ParticipantsList'])){
                                $wname = $_POST['web_name'];
                    ?>
                    <div class="d-flex justify-content-center">
                        <form method="post" class="mb-2" action="../../code.php">
                            <input type="hidden" name="web_name" value="<?php echo $wname; ?>"/>
                                <button type="submit" id = "generateBtn" class="btn btn-success btn-icon-text" name="GenerateCertificateBtn" value="GenerateCertificate">
                                    <i class="mdi mdi-upload btn-icon-prepend"></i>  
                                        <?php 
                                                if($mail_sent == 'Yes'){
                                                    echo "Generate Certificate";
                                        ?>

                                                <script>
                                                    document.getElementById('generateBtn').disabled = true;
                                                </script>

                                        <?php
                                                }
                                                else if(isset($_SESSION['records'])){
                                                  echo "Generate Certificate";
                                                  ?>
          
                                                          <script>
                                                              document.getElementById('generateBtn').disabled = true;
                                                          </script>
          
                                                  <?php
                                                  unset($_SESSION['records']);
                                                }
                                                else if($mail_sent == 'No' && !isset($_SESSION['prtcpts'])){
                                                    echo "Generate Certificate of first 10 Participants";
                                                }
                                                else if(isset($_SESSION['prtcpts']) && $mail_sent == 'No' ){
                                                    echo "Generate Certificate of ".$_SESSION['prtcpts']." 10 Participants";
                                                    unset($_SESSION['prtcpts']);
                                                }
                                                else if(isset($_SESSION['cmpltd']) || $mail_sent == 'Yes'){
                                                    echo "Generate Certificate";
                                        ?>

                                                <script>
                                                    document.getElementById('generateBtn').disabled = true;
                                                </script>

                                        <?php
                                                }
                                        ?>
                                </button>
                        </form>
                        <?php
                            }
                        ?>
                      </div>
                  </div>
                </div>
        </div>
       


    <?php
include('../../includes/participants/script.php');
include('../../includes/participants/footer.php');
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