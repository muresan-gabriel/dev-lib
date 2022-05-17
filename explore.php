<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$db = $con;
$tableName = 'assets';
$columns = ['id', 'user_id', 'name', 'thumbnail', 'status'];

function fetch_data($db, $tableName, $columns) {
  $columnName = implode(', ', $columns);
  $query = "select ".$columnName." from $tableName"." order by id desc";
  $result = $db->query($query);
  if($result== true){ 
    if ($result->num_rows > 0) {
       $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
       $msg= $row;
    }
  }
  return $msg;
}

$fetchData = fetch_data($db, $tableName, $columns);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>dev.lib - Explore</title>
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
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>

    <!-- TAGS : ICONS, ILLUSTRATIONS, BUTTONS, GRADIENTS -->
    <!-- SOFTWARE TAGS: PHOTOSHOP, ILLUSTRATOR, CANVA, BLENDER, FIGMA -->

    <!-- FILTER AND SEARCH SECTION -->


<!-- FILTERS -->
        <div class="accordion filter-accordion container" id="accordionFilter">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button
                class="accordion-button accordion-filter-explore collapsed shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseOne"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
                Filter <span class="badge rounded-pill filter-tag filter-tag-beta"
                >NOT IMPLEMENTED</span
              >
              </button>
            </h2>
            <div
              id="collapseOne"
              class="accordion-collapse collapse"
              aria-labelledby="headingOne"
              data-bs-parent="#accordionFilter"
            >
              <div class="accordion-body accordion-body-filter">
                <p>
                  <strong class="filter-by-tag-anchor">Filter by tag</strong>
                </p>

                <!-- ELEMENTS -->
                <a href="#"
                  ><span
                    class="badge rounded-pill filter-tag filter-tag-illustrations"
                    >Illustrations</span
                  ></a
                >

                <!-- ELEMENTS -->
                <a href="#"
                  ><span class="badge rounded-pill filter-tag filter-tag-icons"
                    >Icons</span
                  ></a
                >

                <!-- ELEMENTS -->
                <a href="#"
                  ><span
                    class="badge rounded-pill filter-tag filter-tag-buttons"
                    >Buttons</span
                  ></a
                >

                <!-- ELEMENTS -->
                <a href="#"
                  ><span
                    class="badge rounded-pill filter-tag filter-tag-gradients"
                    >Gradients</span
                  ></a
                >
                <p>
                  <strong class="filter-by-tag-anchor"
                    >Filter by software</strong
                  >
                </p>

                <!-- ELEMENTS -->
                <a href="#"
                  ><span
                    class="badge rounded-pill filter-tag filter-tag-photoshop"
                    >Photoshop</span
                  ></a
                >

                <!-- ELEMENTS -->
                <a href="#"
                  ><span
                    class="badge rounded-pill filter-tag filter-tag-illustrator"
                    >Illustrator</span
                  ></a
                >

                <!-- ELEMENTS -->
                <a href="#"
                  ><span class="badge rounded-pill filter-tag filter-tag-figma"
                    >Figma</span
                  ></a
                >

                <!-- ELEMENTS -->
                <a href="#"
                  ><span
                    class="badge rounded-pill filter-tag filter-tag-blender"
                    >Blender</span
                  ></a
                >
              </div>
            </div>
          </div>
        </div>
        <!-- FILTERS -->

        <!-- SEARCH BOX  -->
        <form class="d-flex container">
          <input
            class="form-control search-bar-explore me-2 shadow-none"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <button class="btn btn-primary submit-search-explore shadow-none" type="submit">
            Search
          </button>
        </form>



    <!-- ASSET SECTION -->
    <div
      class="explore-section container-fluid row row-cols-1 row-cols-lg-5 g-4"
    >
    <?php 
      $sn = 1;
      foreach($fetchData as $data) {
        if ($data['status'] === 'approved') {
    ?>
      <!-- POST IN COLUMN -->
      
      <div class="col asset-column">
        <div class="card asset-post bg-dark text-white">
          <img
            src="<?php echo 'src/img/assets-imgs/'.$data['thumbnail'] ?>"
            class="card-img asset-card-bg asset-explore-img"
            alt="Asset Image"
          />
          <div
            class="d-flex justify-content-center align-items-center card-img-overlay text-asset-container"
          > 
            <h5 class="card-title asset-name"><?php echo $data['name'] ?></h5>
            <!-- HREF CHANGES DEPENDING ON ASSET -->
            <a href="<?php echo '/dev.lib/asset.php?id='.$data['id'] ?>" class="stretched-link"></a>
          </div>
        </div>
      </div>
      <?php
        $sn++;
      }}
      ?>



    </div>

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
  </body>
</html>
