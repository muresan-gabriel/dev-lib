<?php
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
  $asset_name = $_POST['asset_name'];
  $description = $_POST['description'];
  $user_id = get_id(check_login($con));

  $thumbnail_name = $_FILES['thumbnail']['name'];
  $thumbnail_size = $_FILES['thumbnail']['size'];
  $tmp_name_thumb = $_FILES['thumbnail']['tmp_name'];
  $error = $_FILES['thumbnail']['error'];
  $asset_file_name = $_FILES['asset_files']['name'];
  $asset_file_size= $_FILES['asset_files']['size'];
  $tmp_name_asset_file = $_FILES['asset_files']['tmp_name'];

  if($error === 0) {
    if ($thumbnail_size > 10000000) {
      $em = "File is too large. Maximum 10 MB.";
      header("Location: publish-asset.php?error=$em");
    } else {
      $thumbnail_ex = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
      $asset_file_ex = pathinfo($asset_file_name, PATHINFO_EXTENSION);
      $thumbnail_ex_lc = strtolower($thumbnail_ex);
      $asset_file_ex_lc = strtolower($asset_file_ex);

      $allowed_exs = array("jpg", "jpeg", "png");
      $allowed_exs_file = array("zip", "rar");
      if (in_array($thumbnail_ex, $allowed_exs) && in_array($asset_file_ex, $allowed_exs_file)) {
        $new_thumbnail_name = uniqid("IMG-", true).'.'.$thumbnail_ex_lc;
        $new_asset_file_name = uniqid("AST-", true).'.'.$asset_file_ex_lc;
        $thumbnail_upload_path = 'src/img/assets-imgs/'.$new_thumbnail_name;
        $asset_file_upload_path = 'src/assets/'.$new_asset_file_name;
        move_uploaded_file($tmp_name_thumb, $thumbnail_upload_path);
        move_uploaded_file($tmp_name_asset_file, $asset_file_upload_path);

        // INSERT INTO DB

        $query = "insert into assets (user_id, name, description, thumbnail, asset_files, status) values ('$user_id', '$asset_name', '$description', '$new_thumbnail_name', '$new_asset_file_name', 'processing')";
        mysqli_query($con, $query);
        header("Location: profile.php");
      } else {
        $em = "You provided a file with a wrong extension. Images use .jpg, .jpeg and .png file extensions while asset files can only be uploaded in .zip or .rar archives.";
        header("Location: publish-asset.php?error=$em");
      }
    }
  } else {
    $em = "Uknown error.";
    header("Location: publish-asset.php?error=$em");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - Upload Asset</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="src/img/boost-img.png"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="src/custom.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="src/script.js"></script>
  </head>
<body>
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
              <a
                class="nav-link navbar-link-devlib"
                aria-current="page"
                href="index.php"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link navbar-link-devlib" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link navbar-link-devlib" href="explore.php"
                >Explore Assets</a
              >
            </li>
          </ul>
          <form class="nav navbar-nav navbar-right">
            <?php if(isset($_SESSION['user_id'])): ?>
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
            <?php else: ?>
            <button
              class="btn m-1 btn-login shadow-none"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target=".navbar-collapse.show"
              onclick="window.location='sign-in.php';"
            >
              Login
            </button>
            <button
              class="btn btn-primary m-1 btn-sign-up shadow-none"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target=".navbar-collapse.show"
              onclick="window.location='sign-up.php';"
            >
              Sign Up
            </button>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </nav>
    <?php if(isset($_SESSION['user_id'])): ?>
      <div class="container container-fluid d-flex justify-content-center align-items-center flex-column publish-asset-container">

      <form method="post" enctype="multipart/form-data">
      <div class="form-group" id="uploadAsset">
        <input
          type="asset_name"
          name="asset_name"
          placeholder="Asset Name"
          class="form-control shadow-none"
          id="assetNameInput"
          aria-describedby="fullNameHelp"
        />
        <textarea
              maxlength="500"
              cols="60" rows="6"
              type="description"
              name="description"
              placeholder="Description"
              class="form-control shadow-none"
              id="assetDesc"
              aria-describedby="emailHelp"
        ></textarea>
        <input class="form-control" type="file" name="thumbnail" id="image" />
        <input class="form-control" type="file" name="asset_files" id="zip" />
        <span class="info-guidelines">Make sure to check our <a class="user-website" href="guidelines.php">guidelines</a> before publishing assets.</span>

        <input class="btn btn-primary form-control" type="submit" name="submit" value="Publish" />
      </form>
      </div>

    <?php else: ?>
      <?php header("Location: index.php");?>
    <?php endif; ?>
</body>
</html>