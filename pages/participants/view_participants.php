<?php

session_start();

if (isset($_SESSION['login'])) {
  if ($_SESSION['login'] === 'Successful') {
    $_SESSION['login'] = "Successful";
    include('../../includes/db.php');
    include('../../includes/participants/header.php');
    include('../../includes/participants/sidebar.php');
    include('../../includes/participants/navbar.php');

    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $row_per_page = 10;
    $result = ($page - 1) * $row_per_page;

?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="text-center">
          <h1>Participants Details</h1>
          <h6><small class="text-muted"> All the details of the participants are mentioned here. </small></h6>
        </div>
        <br /><br />
        <?php
        if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
          echo "<p class='bg text-success'>" . $_SESSION['success'] . "</p>";
          unset($_SESSION['success']);
        }

        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
          echo "<p class='text-danger'>" . $_SESSION['status'] . "</p>";
          unset($_SESSION['status']);
        }

        ?>
        <form method="post" action="../../code.php" enctype="multipart/form-data">
          <div class="form-group col-sm-4">
            <label> Import the .csv file here</label>
            <div class="input-group">
              <label for="upload" class="input-group-prepend">
                <span class="input-group-text">Choose File</span>
              </label>
              <input type="file" id="upload" name="upload" hidden />
              <input type="text" class="form-control" id="file_name" required />
              <div class="input-group-append">
                <input class="btn btn-primary" type="submit" name="importBtn" value="Import">
              </div>
            </div>
          </div>
        </form>
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
                      <th> Event Name </th>
                      <th> Certficate Generated </th>
                    </tr>
                  </thead>
                  <?php
                  $query = "SELECT * FROM feedback ORDER BY F_id DESC LIMIT $result, $row_per_page";
                  $query_run = mysqli_query($conn, $query);
                  if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                  ?>
                      <tbody>
                        <tr class="text-center">
                          <td><?php echo $row['name'] ?></td>
                          <td><?php echo $row['organisation'] ?></td>
                          <td><?php echo $row['email_id'] ?></td>
                          <td><?php echo $row['event_name'] ?></td>
                          <td><?php if ($row['mail_sent'] == 0) {
                                echo 'No';
                              } else {
                                echo 'Yes';
                              } ?></td>
                        </tr>
                      </tbody>
                  <?php
                    }
                  } else
                    echo "No Records Found";
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php
        $qr = "SELECT * from feedback";
        $r = mysqli_query($conn, $qr);
        $total_rows = mysqli_num_rows($r);
        $total_pages = ceil($total_rows / $row_per_page);
        ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <?php
            if ($page > 1) {
              $switch = "";
            } else {
              $switch = "disabled";
            }
            if ($page < $total_pages) {
              $nswitch = "";
            } else {
              $nswitch = "disabled";
            }
            ?>
            <li class="page-item <?= $switch ?>">
              <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
            </li>
            <?php
            for ($opage = 1; $opage <= $total_pages; $opage++) {
            ?>
              <li class="page-item"><a class="page-link" href="?page=<?= $opage ?>"><?= $opage ?></a></li>
            <?php
            }
            ?>
            <li class="page-item <?= $nswitch ?>">
              <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
          </ul>
        </nav>
      </div>


  <?php
    include('../../includes/participants/script.php');
    include('../../includes/participants/footer.php');
  }
} else {
  echo "<script>
          alert('You have been logged out. Please login again to continue');
          window.location.href='../../index.php';
        </script>";
}
  ?>