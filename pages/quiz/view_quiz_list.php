<?php

session_start();

if(isset($_SESSION['login']))
{
  if($_SESSION['login'] === 'Successful')
  {
      $_SESSION['login'] = "Successful";
      include('../../includes/db.php');
include('../../includes/quiz/header.php');
include('../../includes/quiz/sidebar.php');
include('../../includes/quiz/navbar.php');  

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="text-center">
            <h1>Choose Event</h1>
            <h6><small class="text-muted"> Choose the event to generate certificate here. </small></h6>
        </div><br/><br/>
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $query = "SELECT * FROM event_details WHERE event_type='Quiz'";
                                $query_run = mysqli_query($conn, $query);
                                if(mysqli_num_rows($query_run)){
                                    while($row=mysqli_fetch_assoc($query_run))
                                    {
                            ?>
                            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                <div class="text-md-center text-xl-left">
                                    <h2 class="mb-1 text-primary"><?=$row['name'] ?></h2>
                                    <h4 class="mb-1"><?=$row['event_type'] ?></h4>
                                        <h5 class="mb-0">Organizer Name: &nbsp;&nbsp;&nbsp; <?=$row['organizer_name'] ?></h5>
                                            <div class="mb-0 mt-2">Dated: <label class="text-success font-weight-medium"><?=$row['dated'] ?></label></div>
                                            <form method="post" action="generate_quiz_certificate.php">
                                            <input type="hidden" name="quiz_name" value="<?=$row['name'] ?>"/>
                                            <button type="submit" class="btn btn-primary btn-icon-text" name="QuizParticipantsList" value="QuizParticipantsList">
                                                <i class="mdi mdi-upload btn-icon-prepend"></i> View Participants 
                                            </button>
                                            </form>
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
include('../../includes/quiz/script.php');
include('../../includes/quiz/footer.php');
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