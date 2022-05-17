<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$db = $con;
$tableName = 'assets';
$columns = ['id', 'user_id', 'name', 'thumbnail','description', 'status'];
$columns_users = ['id', 'user_id', 'full_name', 'username','email','bio','website','role'];

function fetch_users($db, $columns_users) {
    $columnName = implode(', ', $columns_users);
    $query = "select ".$columnName." from users";
    $result = $db->query($query);
      $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
      $msg= $row;
    return $msg;
  }

function fetch_data_processing($db, $tableName, $columns) {
  $columnName = implode(', ', $columns);
  $query = "select ".$columnName." from $tableName"." where status = 'processing'";
  $result = $db->query($query);
    $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $msg= $row;
  return $msg;
}

function fetch_data_approved($db, $tableName, $columns) {
    $columnName = implode(', ', $columns);
    $query = "select ".$columnName." from $tableName"." where status = 'approved'";
    $result = $db->query($query);
      $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
      $msg= $row;
    return $msg;
}
function fetch_data_declined($db, $tableName, $columns) {
    $columnName = implode(', ', $columns);
    $query = "select ".$columnName." from $tableName"." where status = 'declined'";
    $result = $db->query($query);
      $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
      $msg= $row;
    return $msg;
}

// function delete_user($db) {
//   $query = "delete from users where id = '$user_id'"
// }

$fetchDataProcessing = fetch_data_processing($db, $tableName, $columns);
$fetchDataApproved = fetch_data_approved($db, $tableName, $columns);
$fetchDataDeclined = fetch_data_declined($db, $tableName, $columns);
$fetchDataUsers = fetch_users($db, $columns_users);
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - Admin Panel</title>
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

  <?php if(isset($_SESSION['user_id']) && get_role(check_login($con)) === 'admin'): ?>
    <!-- NAVBAR CONTENT -->
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
    <!-- END NAV BAR CONTENT -->
    <div class="container-fluid d-flex flex-column align-content-center">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link disabled">Table Navigator</a>
        </li>
        <li class="nav-item">
            <a class="nav-link about-link" href="#processing">Processing Status</a>
        </li>
        <li class="nav-item">
            <a class="nav-link about-link" href="#approved">Approved Status</a>
        </li>
        <li class="nav-item">
            <a class="nav-link about-link" href="#declined">Declined Status</a>
        </li>
        <li class="nav-item">
            <a class="nav-link about-link" href="#users">Users</a>
        </li>
    </ul>
        <h4 class="display-4" id="processing">Processing status</h4>
            <table class="">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Asset ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Asset Name</th>
                    <th scope="col">Asset Description</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sn = 1;
                    foreach($fetchDataProcessing as $dataProcessing) {
                ?>
                    <tr>
                    <th scope="row"><?php echo $sn; ?></th>
                    <td><?php echo $dataProcessing['id']; ?></td>
                    <td><?php echo $dataProcessing['user_id']; ?></td>
                    <td><?php echo $dataProcessing['name']; ?></td>
                    <td><?php echo $dataProcessing['description']; ?></td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataProcessing['id'] ?>"/>
                            <input type="submit" name="approve_asset" value="Approve" class="btn btn-primary"/>
                        </form> <!-- FISIER SEPARAT PT FUNCTIE -->
                    </td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataProcessing['id'] ?>"/>
                            <input type="submit" name="decline_asset" value="Decline" class="btn btn-danger"/>
                        </form>
                    </td>
                    </tr>
                    <?php
                        $sn++;
                    }
                    ?>
                </tbody>
                </table>
            <h4 class="display-4" id="approved">Approved status</h4>
            <table class="">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Asset ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Asset Name</th>
                    <th scope="col">Asset Description</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <?php 
                    $sn = 1;
                    foreach($fetchDataApproved as $dataApproved) {
                ?>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $sn; ?></th>
                    <td><?php echo $dataApproved['id']; ?></td>
                    <td><?php echo $dataApproved['user_id']; ?></td>
                    <td><?php echo $dataApproved['name']; ?></td>
                    <td><?php echo $dataApproved['description']; ?></td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataApproved['id'] ?>"/>
                            <input type="submit" name="process_asset" value="Place in Processing" class="btn btn-secondary"/>
                        </form> <!-- FISIER SEPARAT PT FUNCTIE -->
                    </td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataApproved['id'] ?>"/>
                            <input type="submit" name="decline_asset" value="Decline" class="btn btn-danger"/>
                        </form>
                    </td>
                    </tr>
                    <?php
                        $sn++;
                    }
                    ?>
                </tbody>
                </table><h4 class="display-4" id="declined">Declined status</h4>
            <table class="">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Asset ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Asset Name</th>
                    <th scope="col">Asset Description</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <?php 
                    $sn = 1;
                    foreach($fetchDataDeclined as $dataDeclined) {
                ?>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $sn; ?></th>
                    <td><?php echo $dataDeclined['id']; ?></td>
                    <td><?php echo $dataDeclined['user_id']; ?></td>
                    <td><?php echo $dataDeclined['name']; ?></td>
                    <td><?php echo $dataDeclined['description']; ?></td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataDeclined['id'] ?>"/>
                            <input type="submit" name="approve_asset" value="Approve" class="btn btn-primary"/>
                        </form> <!-- FISIER SEPARAT PT FUNCTIE -->
                    </td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataDeclined['id'] ?>"/>
                            <input type="submit" name="process_asset" value="Place in Processing" class="btn btn-secondary"/>
                        </form> <!-- FISIER SEPARAT PT FUNCTIE -->
                    </td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="asset_id" value="<?= $dataDeclined['id'] ?>"/>
                            <input type="submit" name="delete_asset" value="Delete" class="btn btn-danger"/>
                        </form> <!-- FISIER SEPARAT PT FUNCTIE -->
                    </td>
                    </tr>
                    <?php
                        $sn++;
                    }
                    ?>
                </tbody>
                </table>
                <h4 class="display-4" id="users">Users</h4>
            <table class="">
                
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Bio</th>
                    <th scope="col">Website</th>
                    <th scope="col">Modify</th>
                    </tr>
                </thead>
                <?php 
                    $sn = 1;
                    foreach($fetchDataUsers as $dataUsers) {
                ?>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $sn; ?></th>
                    <td><?php echo $dataUsers['id']; ?></td>
                    <td><?php echo $dataUsers['user_id']; ?></td>
                    <td><?php echo $dataUsers['full_name']; ?></td>
                    <td><?php echo $dataUsers['username']; ?></td>
                    <td><?php echo $dataUsers['email']; ?></td>
                    <td><?php echo $dataUsers['bio']; ?></td>
                    <td><?php echo $dataUsers['website']; ?></td>
                    <td>
                    <form method="post" action="functions.php">
                            <input type="hidden" name="user_id" value="<?= $dataUsers['user_id'] ?>"/>
                            <input type="submit" name="delete_user" value="Delete" class="btn btn-danger"/>
                        </form> <!-- FISIER SEPARAT PT FUNCTIE -->
                    </td>
                    </tr>
                    <?php
                        $sn++;
                    }
                    ?>
                </tbody>
                </table>
    </div>
    <?php else: ?>
                <div class="d-flex container-fluid flex-column justify-content-center align-items-center" style="height: 90vh;">
                <h1 class="display-4">You cannot access this page.</h1>
                <p><a href="index.php" class="about-link" style="font-size: 26px;">Back home</a></p>
                </div>
            <?php endif; ?>
  </body>
</html>