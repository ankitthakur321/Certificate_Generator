<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" style="text-decoration:none;color:white;" href="../../dashboard.php">CG ADMIN</a>
          <a class="sidebar-brand brand-logo-mini" style="text-decoration:none;color:white;" href="../../dashboard.php">CG</a>
        </div>
        <ul class="nav">
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../dashboard.php">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#webinar" aria-expanded="false" aria-controls="webinar">
              <span class="menu-icon">
                <i class="mdi mdi-laptop-mac"></i>
              </span>
              <span class="menu-title">Events</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="webinar">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../events/add_event.php">Add Event</a></li>
                <li class="nav-item"> <a class="nav-link" href="../events/view_events.php">View Events</a></li>
                <li class="nav-item"> <a class="nav-link" href="../events/view_quiz_events.php">View Quiz Events</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#participants" aria-expanded="false" aria-controls="participants">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Participants</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="participants">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="view_participants.php">View Participants</a></li>
                <li class="nav-item"> <a class="nav-link" href="view_webinar_list.php">Generate Certificate</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#quiz" aria-expanded="false" aria-controls="quiz">
              <span class="menu-icon">
                <i class="mdi mdi-file-document"></i>
              </span>
              <span class="menu-title">Quiz</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="quiz">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../quiz/view_quiz_participants.php">View Participants</a></li>
                <li class="nav-item"> <a class="nav-link" href="..//quiz/view_quiz_list.php">Generate Certificate</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">