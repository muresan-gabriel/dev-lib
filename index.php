<?php
session_start();

require('../vendor/autoload.php');

include("connection.php");
include("functions.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - Open Source Assets</title>
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

    <!-- END NAV BAR CONTENT -->

    <!-- MAIN SECTION -->
    <?php if(isset($_SESSION['user_id'])): ?>
      <h1 style="color: blue;">Wow</h1>
    <?php else: ?>
    <div class="container-fluid main-section justify-content-center">
      <h2 class="display-4 main-heading">
        Get open-source assets.<br />
        Boost your ideas.
      </h2>
      <p class="main-paragraph">
        Download the latest open-source assets <br class="line-break" />for your
        projects or contribute.
      </p>
      <div class="d-flex justify-content-center btn-cta-container">
        <button
          class="btn btn-primary m-1 btn-cta shadow-none"
          type="button"
          onclick="window.location='sign-up.php';"
        >
          Get Started
        </button>
      </div>
    </div>

    <!-- END MAIN SECTION -->

    <div class="container-fluid section-pros">
      <div class="second-heading">
        <h2 class="display-4 second-heading">The pros love it</h2>
      </div>

      <p class="second-paragraph">
        Multiple teams from international companies <br />
        use the assets in their projects
      </p>
    </div>

    <marquee behavior="scroll" direction="left" loop="100">
      <img
        src="src/img/amazon-logo.png"
        class="logos"
        width="150px"
        alt="logos"
      />
      <img
        src="src/img/google-logo.png"
        class="logos"
        width="150px"
        alt="logos"
      />
      <img
        src="src/img/samsung-logo.png"
        class="logos"
        width="150px"
        alt="logos"
      />
      <img
        src="src/img/github-logo.png"
        class="logos"
        width="150px"
        alt="logos"
      />
      <img
        src="src/img/visa-logo.png"
        class="logos"
        width="150px"
        alt="logos"
      />
      <img
        src="src/img/microsoft-logo.png"
        class="logos"
        width="150px"
        alt="logos"
      />
    </marquee>


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
    <?php endif; ?>
  </body>
</html>
