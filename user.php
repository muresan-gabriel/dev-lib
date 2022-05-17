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
$user_data = check_login($con);
$asset_data = get_all_assets($con, $_GET['id']);
$user_profile_data = get_profile_data($con, $_GET['id']);

function fetch_tags($db, $tagsTableName, $tagsColumns, $user_id) {
  $columnName = implode(', ', $tagsColumns);
  $query = "select ".$columnName." from $tagsTableName"." where user_id = "."$user_id";
  $result = $db->query($query);

       $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
       $msg= $row;

  return $msg;
}

function fetch_data($db, $tableName, $columns, $user_id) {
    $columnName = implode(', ', $columns);
    $query = "select ".$columnName." from $tableName"." where user_id = "."$user_id";
    $result = $db->query($query);
  
  
         $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
         $msg= $row;
  
    return $msg;
  
  }
  
  $fetchData = fetch_data($db, $tableName, $columns, $_GET['id']);
  $fetchTagData = fetch_tags($db, $tagsTableName, $tagsColumns, $_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - <?php echo $user_profile_data['full_name'] ?></title>
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
  </head>
  <body>
  <?php if(isset($_SESSION['user_id'])): ?>
    <?php
        if($_SESSION['user_id'] === $_GET['id']) {
            header("Location: profile.php");
        }
        
    ?>
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
            src="<?php echo 'src/img/profile-imgs/'.$user_profile_data['profile_picture'] ?>"
          />
        </div>
        <div class="col-7 user-details">
          <h1 class="display-4 full-name-profile"><?php echo $user_profile_data['full_name'] ?></h1>
          <h2 class="display-4 username-profile"><?php echo '@'.$user_profile_data['username'] ?></h2>
        </div>
        <div class="description-profile-container col-sm-12 col-md flex-column">
          <p class="description-profile">
          <?php echo $user_profile_data['bio'] ?>
          </p>
          <a class="user-website" href="https://<?php echo $user_profile_data['website'] ?>" target="_blank"><?php echo $user_profile_data['website'] ?></a>
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

        <!-- FOOTER -->
        <div class="container footer-container">
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

        <div class="col">
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
    <script src="src/script.js" defer></script>
  <?php endif; ?>
  </body>
</html>