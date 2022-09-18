<?php

session_start();

if(isset($_SESSION['login']))
{
  if($_SESSION['login'] === 'Successful')
  {
      $_SESSION['login'] = "Successful";
      include('../../includes/db.php');      
include('../../includes/webinars/header.php');
include('../../includes/webinars/sidebar.php');
include('../../includes/webinars/navbar.php');  

?>

<div class="main-panel">
    <div class="content-wrapper">
      <div class = "text-center">
        <h1>Add Event</h1>
        <h6><small class="text-muted"> You can add an event here. </small></h6>
      </div>
      <br/><br/>
        <?php
	            	if(isset($_SESSION['success']) && $_SESSION['success'] != '')
	            	{
	            		echo "<p class='bg text-success'>".$_SESSION['success']."</p>";
	            		unset($_SESSION['success']);
	            	}

	            	if(isset($_SESSION['status']) && $_SESSION['status'] != '')
	            	{
	            		echo "<p class='text-danger'>".$_SESSION['status']."</p>";
	            		unset($_SESSION['status']);
	            	}

        ?>
      <div class="d-flex justify-content-center">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post" id="FacultySignupForm" action="../../code.php">
                <div class="form-group">
                  <label for="InputName">Name of Event</label>
                  <input type="text" class="form-control" id="InputName" placeholder="Enter Name" name="Name" required>
                </div>
                <div class="form-group">
                  <label for="InputSpeaker">Organizer Name</label>
                    <input type="text" class="form-control" id="InputDated" placeholder="Enter Organizer Name" name="OrganizerName" required>
                </div>
                <div class="form-group">
                  <label for="InputDated">Date of Event</label>
                    <input type="date" class="form-control" id="InputDated" placeholder="Enter Date" name="Dated" required>
                </div>
                <div class="form-group">
                  <label for="InputType">Type of Event</label>
                    <input type="text" class="form-control" id="InputType" placeholder="Enter Type of Event" name="EventType" required>
                </div>
                <button type="submit" class="btn btn-primary" name="AddWebinarBtn" value="AddWebinarBtn" >Add Event</button>
              </form>
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
          window.location.href='../../../index.php';
        </script>";
}
?>