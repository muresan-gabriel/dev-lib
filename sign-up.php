<?php
session_start();

  include("connection.php");
  include("functions.php");

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    // something was posted
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($full_name) && !empty($full_name) && !empty($email) && !empty($password) && !is_numeric($email))
    {
      $user_id = random_num(20);
      $query = "insert into users (user_id,full_name,username,email,password,role,profile_picture) values ('$user_id','$full_name','$username','$email','$password','user','default.png')";

      mysqli_query($con, $query);

      header("Location: sign-in.php");
      die;
    } 
    else
    {
      echo "Please enter some valid information.";
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - Sign Up</title>
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
  <?php if(isset($_SESSION['user_id']))
    header("Location: index.php");
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
          <form class="nav navbar-nav navbar-right">
            <!-- <button
              class="btn btn-secondary m-1 btn-publish"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target=".navbar-collapse.show"
              onclick="window.location='sign-up.php';"
            >
              Publish Asset ONLY IF LOGGED IN
            </button> -->
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
          </form>
        </div>
      </div>
    </nav>
    <div class="container-fluid justify-content-center">
    <h4 class="sign-in-text">Create a new account</h4>

    <form class="login-form " method="post">
      <div class="form-group">
        <input
          type="full-name"
          name="full_name"
          placeholder="Full Name"
          class="form-control auth-inputs"
          id="exampleInputName1"
          aria-describedby="fullNameHelp"
        />
        <input
          type="username"
          name="username"
          placeholder="Username"
          class="form-control auth-inputs"
          id="exampleInputName1"
          aria-describedby="fullNameHelp"
        />
        <input
          type="email"
          name="email"
          placeholder="Email"
          class="form-control auth-inputs shadow-none"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
        />
        <input
          type="password"
          name="password"
          placeholder="Password"
          class="form-control auth-inputs shadow-none"
          id="exampleInputPassword1"
        />
        <button type="submit" class="btn btn-primary auth-inputs form-control btn-sign-up-page shadow-none" value="Signup">
        Sign Up
        </button>
      </div>
      <p class="no-alr-acc">Already have an account? <a class="sign-in-up-a" href="sign-in.php">Sign In</a></p>
    </form>
    </div>
  </body>
</html>
