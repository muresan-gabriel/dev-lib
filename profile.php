<?php
session_start();

include("connection.php");
include("functions.php");


$user_data = check_login($con);
$db = $con;
$tableName = 'assets';
$columns = ['id', 'user_id', 'name', 'thumbnail', 'status'];
$tagsColumns = ['id','user_id','tag_name','tag_color'];
$tagsTableName = 'user_tags';

function fetch_data($db, $tableName, $columns, $user_id) {
  $columnName = implode(', ', $columns);
  $query = "select ".$columnName." from $tableName"." where user_id = "."$user_id";
  $result = $db->query($query);


       $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
       $msg= $row;

  return $msg;

}

function fetch_tags($db, $tagsTableName, $tagsColumns, $user_id) {
  $columnName = implode(', ', $tagsColumns);
  $query = "select ".$columnName." from $tagsTableName"." where user_id = "."$user_id";
  $result = $db->query($query);

       $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
       $msg= $row;

  return $msg;
}

$fetchData = fetch_data($db, $tableName, $columns, $_SESSION['user_id']);
$fetchTagData = fetch_tags($db, $tagsTableName, $tagsColumns, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<head lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - <?php echo get_name(check_login($con)) ?></title>
    <link rel="icon" type="image/x-icon" href="src/img/boost-img.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="src/custom.css" />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script src="src/script.js"></script>
  </head>
    <!-- NAV BAR CONTENT -->
<body>
  <?php if(isset($_SESSION['user_id'])): ?>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <a class="navbar-brand" href="index.php">dev.lib</a>
        <button
          class="navbar-toggler shadow-none"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarText"
          aria-controls="navbarText"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link navbar-link-devlib" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link navbar-link-devlib" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link navbar-link-devlib" href="explore.php">Explore Assets</a>
            </li>
          </ul>

          <div class="nav navbar-nav navbar-right">
            <div class="dropstart">
              <button
                class="btn btn-primary m-1 dropdown-toggle shadow-none"
                type="button"
                id="dropdownMenuProfile"
                data-bs-toggle="dropdown"
              >
                <?php echo '@' . get_username(check_login($con)) ?>
              </button>

              <ul
                class="dropdown-menu dropdown-menu-dark"
                aria-labelledby="dropdownMenuProfile"
              >
                <li>
                  <a class="dropdown-item" href="profile.php">Profile</a>
                </li>
                <li><a class="dropdown-item" href="publish-asset.php">Publish Asset</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <hr class="divider-light" />

    <!-- PROFILE SECTION -->
    <div class="container-fluid profile-section row">

      <div class="col-lg-2"></div>

      <div class="col-lg-3 left-nav-profile row">
        <div class="col-5">
          <img
            width="150px"
            class="rounded-circle profile-picture-display"
            src="<?php echo 'src/img/profile-imgs/'.get_profile_pic(check_login($con)) ?>"
          />
        </div>
        <div class="col-7 user-details">
          <h1 class="display-4 full-name-profile"><?php echo get_name(check_login($con)) ?></h1>
          <h2 class="display-4 username-profile"><?php echo '@' . get_username(check_login($con)) ?></h2>
        </div>
        <div class="description-profile-container col-sm-12 col-md flex-column">
          <p class="description-profile">
          <?php echo get_bio(check_login($con)) ?>
          </p>
          <a class="user-website" href="https://<?php echo get_website(check_login($con)) ?>" target="_blank"><?php echo get_website(check_login($con)) ?></a>
        </div>
        <!-- TAGS SEGMENT -->
        <div class="tags-profile-container col-12">
          <!-- TAGS HEADER -->
          <h4 class="dispaly-4 profile-headers tags-header">Tags</h4>
          <!-- HERE ARE TAGS -->
          <?php 
      foreach($fetchTagData as $tagData) {
    ?>
          <span class="badge rounded-pill user-tag" style="<?php echo "color: ".$tagData['tag_color'] ?>"><?php echo strtoupper($tagData['tag_name']); ?></span>
          <?php 
      }
        ?>
        </div>
        <div class="d-flex flex-column">
        <button class="btn btn-primary m-1 edit-profile-button shadow-none" type="button" onclick="window.location='edit-profile.php';">
          Edit profile
        </button>
        <?php if(get_role(check_login($con)) === 'admin'): ?>
        <button class="btn btn-info m-1 shadow-none" type="button" onclick="window.location='admin-panel.php';">
          Admin Panel
        </button>
        <?php endif; ?> 
        <button class="btn btn-outline-danger m-1 edit-profile-button shadow-none" type="button" onclick="window.location='logout.php';">
          Sign out
        </button></div>
      </div>

      <div class="col-lg-5 main-content-profile row">
        <!-- HEADER -->
        <div class="col-12 header-container-profile">
          <h4
            class="display-4 profile-headers profile-section-header top-assets"
          >
            My assets
          </h4>
        </div>
        <!-- TOP ASSETS SECTION -->
        <div class="explore-section container-fluid col-12 row row-cols-1 row-cols-lg-3 g-4">
          <!-- POST IN COLUMN -->
          <?php 
      $sn = 1;

      foreach($fetchData as $data) {
    ?>
          <div class="col asset-column flex-column">
            <div class="card asset-post bg-dark text-white">
              <img
                src="<?php echo 'src/img/assets-imgs/'.$data['thumbnail'] ?>"
                class="card-img asset-card-bg user-profile-asset-thumbnail"
                alt="Asset Image"
              />
              <div
                class="d-flex justify-content-center align-items-center card-img-overlay text-asset-container"
                >
                <?php if($data['status'] === 'approved'): ?>
                <h5 class="card-title asset-name asset-name-user-profile"><?php echo $data['name'] ?></h5>
                <?php endif; ?>
                <?php if($data['status'] === 'processing'): ?>
                  <h5 class="card-title asset-name asset-name-user-profile">Processing</h5>
                <?php endif; ?>
                <?php if($data['status'] === 'declined'): ?>
                  <h5 class="card-title asset-name asset-name-user-profile">Declined</h5>
                <?php endif; ?>
                <!-- HREF CHANGES DEPENDING ON ASSET -->
                <a href="<?php echo '/dev.lib/asset.php?id='.$data['id'] ?>" class="stretched-link"></a>
              </div>
            </div>
          </div>
          <?php 
        $sn++;
      }
        ?>
        </div>

        </div></div>

      <!-- MARGIN BY COL -->
    <div class="col-lg-2"></div>


    <!-- FOOTER -->
      <!-- MARGIN BY COL -->
      <div class="col-lg-2"></div>
    </div>
    <!-- FOOTER -->
    <div class="container">
      <footer class="row row-cols-1 row-cols-lg-5 border-top footer-content">
        <div class="col copyright-footer">
          <a
            href="/"
            class="d-flex align-items-center mb-3 link-dark text-decoration-none"
          >
            <svg class="bi me-2" width="40" height="32">
              <use xlink:href="#bootstrap"></use>
            </svg>
          </a>
          <p class="text-muted">© 2022 - dev.lib</p>
        </div>

        <div class="col copyright-footer"></div>

        <div class="col footer-container">
          <h5 class="section-footer">Product</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Features</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Team</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Resources</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Roadmap</a>
            </li>
            >
          </ul>
        </div>

        <div class="col">
          <h5 class="section-footer">Support</h5>
          <ul class="nav flex-column">
            <ul class="nav flex-column">
              <li class="nav-item mb-2">
                <a href="#" class="nav-link p-0 text-muted">Documentation</a>
              </li>
              <li class="nav-item mb-2">
                <a href="#" class="nav-link p-0 text-muted">Forum</a>
              </li>
              <li class="nav-item mb-2">
                <a href="#" class="nav-link p-0 text-muted">Guidelines</a>
              </li>
              <li class="nav-item mb-2">
                <a href="#" class="nav-link p-0 text-muted">Contact</a>
              </li>
          </ul>
        </div>

        <div class="col">
          <h5 class="section-footer">Platform</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="about.php" class="nav-link p-0 text-muted">About</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Blog</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Inclusion</a>
            </li>
          </ul>
        </div>
      </footer>
    </div>
    <?php else: ?>
      <div class="container container-fluid d-flex justify-content-center align-items-center flex-column container-no-login">
        <h1 class="display-4" style="text-align: center;">You must <a class="about-link" href="sign-up.php">create</a> an account to view this page.</h1>
        <p class="main-paragraph">Already have an account? <a class="about-link" href="sign-in.php">Login</a></p>
      </div>
    <?php endif; ?>
  </body>
</html>
