<?php
session_start();

include("connection.php");
include("functions.php");
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - About</title>
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
    <!-- WEB FUNCTIONS -->

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
              <a class="nav-link navbar-link-devlib" href="#">About</a>
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

    <div class="container-fluid row row-cols-1 row-cols-lg-2 g-4">
      <div class="col"><h4 id="aboutHeading" class="display-4 main-heading sticky-top about-sections-headings">About</h4></div>
      <div class="col"><p class="about-paragraph"><a class="about-link" href="index.php">dev.lib</a> is a platform crafted with 💖 for designers and developers.
                                                                                                    The mission is to centralize professional, open-source assets in one place to make them
                                                                                                  easily accessible and allow everyone to use the assets in their projects, no matter if they're
                                                                                                personal projects or large-scale solutions. <br><br>We assure quality by offering creators
                                                                                              of assets guidelines for the final bits of the assets that touch our platform to ensure
                                                                                            constitency throughout all resources. In the end, we review each asset and offer guidance where
                                                                                          needed.<br><br>Many people use the assets on a daily basis, including teams in big companies, such as 
                                                                                        <span class="company-about">Facebook</span>, <span class="company-about">Amazon</span>, <span class="company-about">GitHub</span>, 
                                                                                        <span class="company-about">Visa</span>, and many more!<br><br>Even if young, the platform offered
                                                                                      a lot to the open-source community, making sure only high-quality assets see the light. The platform follows
                                                                                    simple principles. As long as an asset is responsive, usable, consistent and top-notch, it is perfect to use in 
                                                                                  any projects.<br><br>We believe everyone should have free access to open-source resources to be able to complete projects
                                                                                with ease or to have consistency in learning processes.</p></div>
    </div>
    <div class="container-fluid row row-cols-1 row-cols-lg-2 g-4">
      <div class="col"><h4 id="aboutHeading" class="display-4 main-heading sticky-top about-sections-headings">Creators</h4></div>
      <div class="col about-paragraph-container"><p class="about-paragraph">If you want yourself to become a creator and post an asset on <a class="about-link" href="index.php">dev.lib</a>, feel free to check
                                                  the <a class="about-link" href="guidelines.php">guidelines</a> we've created and the <a class="about-link" href="documentation.php">documentation</a> to make
                                                sure your asset maintain the constistency of the other projects and offer other people a good time exploring with your resources.<br><br>If you only want
                                              to download and use resources, that's up to you and it's absolutely alright! In addition to the open-source beliefs, we believe in support. If you ever found
                                            yourself absolutely astonished by an asset, we encourage you to donate to the creator, no matter the amount, via his profile page or on the asset's page.<br><br>
                                          We never want to bother you from your goals, so these donation buttons will never take up your entire screen. Look for them if you want to use them, but we don't want
                                        to disturb you in any way with annoying pop-ups.</p></div>
    </div>
    <div class="container-fluid main-section justify-content-center about-heading-container">
      <h2 class="display-4 main-heading">
        Love what you're hearing? Join the open-source community now!
      </h2>
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
