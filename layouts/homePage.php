<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../login.php");
      exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Acceuil</title>
      <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../assets/vendors/fontawesome/css/all.min.css" />
      <link rel="stylesheet" href="../style.css" type="text/css" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
      </script>
</head>

<body>

      <!-- Navbar -->
      <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                  <!-- Container wrapper -->
                  <div class="container-fluid">
                        <!-- Toggle button -->
                        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                              data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                              aria-expanded="false" aria-label="Toggle navigation">
                              <i class="fas fa-bars"></i>
                        </button>

                        <!-- Collapsible wrapper -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                              <!-- Navbar brand -->
                              <a class="navbar-brand logo">CESITAGE</a>
                        </div>
                        <!-- Collapsible wrapper -->
                        <div class="" id="navbarNavAltMarkup">
                              <div class="navbar-nav">
                                    <a class="nav-link active" href="#">Acceuil</a>
                                    <a class="nav-link" href="./offres/listOffre.php">Offres</a>
                                    <a class="nav-link" href="./Entreprise/listEntreprise.php">Entreprises</a>
                              </div>
                        </div>

                        <div class="dropdown">
                              <button class="btn btn-outline-info dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user mx-1"></i>
                                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="./comptes/profil.php">Profil</a></li>
                                    <?php
                                    if ($_SESSION['id'] == 1) {
                                          echo '<li><a class="dropdown-item" href="./admin/adminPage.php">Paramètres</a></li>';
                                    } ?>
                                    <li><a class="dropdown-item" href="logout.php" class="">Se déconnecter</a></li>
                              </ul>
                        </div>
                  </div>
            </nav>
      </div>
      <?php

if (($_SESSION["id"]) === 1 || $_SESSION["id"] === 4) {

?>
      <div class="container mt-5 mb-3">
            <div class="row">
                  <div class="col-md-4">
                        <div class="card p-3 mb-2">
                              <div class="mt-5">
                                    <h3 class="heading">1<br>CREER LES ENTREPRISES</h3>
                                    <div class="mt-5">
                                          <div class="progress" role="progressbar" aria-label="Example 1px high"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                                style="height: 1px">
                                                <div class="progress-bar" style="width: 40%"></div>
                                          </div>
                                          <div class="mt-3"> <span class="text1"></span>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-4">
                        <div class="card p-3 mb-2">
                              <div class="mt-5">
                                    <h3 class="heading">2<br>CREER LES OFFRES</h3>
                                    <div class="mt-5">
                                          <div class="progress" role="progressbar" aria-label="Example 1px high"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                                style="height: 1px">
                                                <div class="progress-bar" style="width: 50%"></div>
                                          </div>
                                          <div class="mt-3"> <span class="text1"></span>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-4">
                        <div class="card p-3 mb-2">
                              <div class="mt-5">
                                    <h3 class="heading">3<br>CREER LES COMPTES</h3>
                                    <div class="mt-5">
                                          <div class="progress" role="progressbar" aria-label="Example 1px high"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                                style="height: 1px">
                                                <div class="progress-bar" style="width: 100%"></div>
                                          </div>
                                          <div class="mt-3"> <span class="text1"></span>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
      <?php }
      ?>
      <!-- <div class="search-form">
            <form class="row g-3">
                  <div class="col-md-10">
                        <input type="text" class="form-control" id="" placeholder="Mots clés">
                  </div>
                  <div class="col-md-2 d-grid gap-2 col-6 mx-auto">
                        <input type="submit" name="login" class="btn btn-primary" value="Rechercher" />
                  </div>
                  <div class="col-md-4">
                        <label for="inputState" class="form-label">Localité</label>
                        <select id="" class="form-select">
                              <option selected>Choisir...</option>
                              <option>...</option>
                        </select>
                  </div>
                  <div class="col-md-4">
                        <label for="" class="form-label">Durée</label>
                        <select id="" class="form-select">
                              <option selected>Choisir...</option>
                              <option>...</option>
                        </select>
                  </div>
                  <div class="col-md-4">
                        <label for="" class="form-label">Rémunération</label>
                        <select id="" class="form-select">
                              <option selected>Choisir...</option>
                              <option>...</option>
                        </select>
                  </div>
            </form>
            </div> -->

      <?php
      include 'home.php';
      ?>
      <?php
      include 'footer.php';
      ?>

      <script src="./assets/vendors/jquery/jquery-3.6.0.min.js"></script>
      <script src="./assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>