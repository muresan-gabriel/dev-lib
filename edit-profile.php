<?php
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
  // something was posted
  $thumbnail_name = $_FILES['profileimage']['name'];
  $thumbnail_size = $_FILES['profileimage']['size'];
  $tmp_name_thumb = $_FILES['profileimage']['tmp_name'];
  $error = $_FILES['profileimage']['error'];
  $name = $_POST['name'];
  $bio = $_POST['bio'];
  $website = $_POST['website'];
  $username = $_POST['username'];
  $user_id = get_id(check_login($con));
  $password = $_POST['password'];
  $email = $_POST['email'];

  if($error === 0) {
    if ($thumbnail_size > 1000000000) {
      $em = "File is too large. Maximum 10 MB.";
      header("Location: edit-profile.php?error=$em");
    } else {
      $thumbnail_ex = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
      $thumbnail_ex_lc = strtolower($thumbnail_ex);
      $new_thumbnail_name = get_profile_pic(check_login($con));

      $allowed_exs = array("jpg", "jpeg", "png");
      if (in_array($thumbnail_ex, $allowed_exs)) {
        $new_thumbnail_name = uniqid("IMG-", true).'.'.$thumbnail_ex_lc;

        $thumbnail_upload_path = 'src/img/profile-imgs/'.$new_thumbnail_name;

        move_uploaded_file($tmp_name_thumb, $thumbnail_upload_path);

        // INSERT INTO DB
        if(!empty($name) && !empty($username))
        {
          $query = "update users set full_name='$name', username='$username', bio='$bio', website='$website', password='$password', email='$email', profile_picture='$new_thumbnail_name' where user_id=$user_id";
      
          $result = mysqli_query($con, $query);
          header("Location: profile.php");
            die;
        }
      } else {
        $em = "You provided a file with a wrong extension. Images use .jpg, .jpeg and .png file extensions while asset files can only be uploaded in .zip or .rar archives.";
        header("Location: profile.php?error=$em");
      }
    }
  }
}

$db = $con;
$tagsColumns = ['id','user_id','tag_name','tag_color'];
$tagsTableName = 'user_tags';

function fetch_tags($db, $tagsTableName, $tagsColumns, $user_id) {
  $columnName = implode(', ', $tagsColumns);
  $query = "select ".$columnName." from $tagsTableName"." where user_id = "."$user_id";
  $result = $db->query($query);

       $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
       $msg= $row;

  return $msg;
}



$fetchTagData = fetch_tags($db, $tagsTableName, $tagsColumns, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - Edit Profile</title>
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
  <body>
    <!-- NAV BAR CONTENT -->

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
            <!-- <button
              class="btn btn-secondary m-1 btn-publish"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target=".navbar-collapse.show"
              onclick="window.location='sign-up.php';"
            >
              Publish Asset ONLY IF LOGGED IN
            </button> -->

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
    <hr class="divider" />

    <!-- PROFILE SECTION -->
    <div class="container-fluid profile-section row">
      <!-- MARGIN BY COL -->

      <div class="col-lg-2"></div>
      <!-- LEFT SIDE OF PROFILE INCLUDING PROFILE PICTURE, NAMES, BIO, TAGS AND EDIT PROFILE BUTTON -->

      <div class="col-lg-3 left-nav-profile row">
        <!-- FIRST SEGMENT OF THE LEFT SIDE CONTAINING PROFILE PICTURE AND NAMES -->
        <div class="col-5">
          <!-- PROFILE PICTURE -->
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
        <!-- DESCRIPTION SEGMENT WHICH OCCUPIES A WHOLE ROW, BUT IS ONLY 9 COLUMNS IN WIDTH -->
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

          <button class="btn btn-outline-danger m-1 cancel-profile-button shadow-none" type="button" onclick="window.location='profile.php';">
            Cancel
          </button>

          <input class="btn btn-success m-1 save-profile-button shadow-none" type="submit" name="submit" form="editProfile" value="Save Changes" />

      </div>
      <!-- RIGHT SIDE AND MAIN SECTION OF PROFILE DISPLAYING ASSETS AND HISTORY -->

      <div class="col-lg-5 main-content-profile row">
        <!-- HEADER -->
        <div class="col-12 header-container-profile">
          <h4
            class="display-4 profile-headers profile-section-header top-assets"
          >
            Edit profile
          </h4>
        </div>
        <!-- EDIT PUBLIC INFORMATION -->
        <div class="no-content-text-container col-12">
          <form id="editProfile" method="post"  enctype="multipart/form-data">
          <label class="input-labels" for="image">Profile Picture</label>
            <input class="form-control" type="file" name="profileimage" id="imageProfile" />
            <label class="input-labels" for="fullNameEdit">Name</label>
            <input
              maxlength="70"
              type="name"
              name="name"
              placeholder="Full Name"
              value="<?php echo get_name(check_login($con)) ?>"
              class="form-control edit-profile-short shadow-none"
              id="fullNameEdit"
              aria-describedby="emailHelp"
            />
            <label class="input-labels" for="userNameEdit">Username</label>
            <input
              maxlength="70"
              type="username"
              name="username"
              placeholder="Username"
              value="<?php echo get_username(check_login($con)) ?>"
              class="form-control edit-profile-short shadow-none"
              id="userNameEdit"
              aria-describedby="emailHelp"
            />
            <label class="input-labels" for="urlEdit">Website</label>
            <input
              maxlength="40"
              type="website"
              name="website"
              placeholder="Website"
              value="<?php echo get_website(check_login($con)) ?>"
              class="form-control edit-profile-short shadow-none"
              id="urlEdit"
              aria-describedby="emailHelp"
            />
            <label class="input-labels" for="bioEdit">Bio</label>
            <textarea
              maxlength="500"
              cols="50" rows="6"
              type="bio"
              name="bio"
              placeholder="Bio"
              class="form-control edit-profile-short shadow-none"
              id="bioEdit"
              aria-describedby="emailHelp"
            /><?php echo get_bio(check_login($con)) ?></textarea>
            <label class="input-labels" for="emailEdit">Email</label>
            <input
              maxlength="40"
              type="email"
              name="email"
              placeholder="Email"
              value="<?php echo get_email(check_login($con)) ?>"
              class="form-control edit-profile-short shadow-none"
              id="emailEdit"
              aria-describedby="emailHelp"
            />
            <label class="input-labels" for="passwordEdit">Password</label>
            <input
              maxlength="40"
              type="password"
              name="password"
              placeholder="Password"
              value="<?php echo get_password(check_login($con)) ?>"
              class="form-control edit-profile-short shadow-none"
              id="passwordEdit"
              aria-describedby="emailHelp"
            />
            <label class="input-labels tags-label">Tags</label>
            <div class="tags-edit-container">
              <!-- HERE ARE TAGS -->
              <?php 
      foreach($fetchTagData as $tagData) {
    ?>
          <span class="badge rounded-pill user-tag" style="<?php echo "color: ".$tagData['tag_color'] ?>"><?php echo strtoupper($tagData['tag_name']); ?></span>
          <?php 
      }
        ?>
            </div>

          </form>
        </div>

      </div>

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
  </body>
</html>
