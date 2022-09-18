        <?php
             $usrnm = $_SESSION['usrnm'];
             $_SESSION['Reg_No'] = $usrnm;
             include('includes/db.php');
        ?>
  
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini text-center" href="dashboard.php">Certificate Generator</a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <!--<img class="img-xs rounded-circle" src="assets/images/faces/face.jpg" alt="DP">-->
                    <p class="mb-0 d-none d-sm-block navbar-profile-name">
                    <?php
                          $query = "SELECT * FROM admin_details WHERE username = '$usrnm'";
                          $query_run = mysqli_query($conn, $query);
                          if(mysqli_num_rows($query_run) > 0)
                          {
                              while($row=mysqli_fetch_assoc($query_run))
                              {
                                  echo $row['Name'];
                              }
                          }
                    ?>
                    </p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="index.php">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                  </a>
              </li>
            </ul>
          </div>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing" style="color:white;"></span>
          </button>
        </nav>