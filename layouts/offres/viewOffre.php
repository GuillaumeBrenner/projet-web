<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

if (isset($_GET['id'])) {
      $sql = "SELECT id_offre, o.Titre, o.Durée, o.Durée, o.nombre_places,o.Remuneration,o.Date_post,o.descrip, v.ville
            FROM offre o
            INNER JOIN site s ON s.id_site = o.id_site 
            INNER JOIN ville v ON v.id_ville = s.id_ville WHERE o.id_offre= " . $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0 " />
      <title>Liste des entreprises</title>
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../../assets/vendors/fontawesome/css/all.min.css" />
      <link rel="stylesheet" href="../../style.css" type="text/css" />

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
</head>

<body>
      <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">

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
                                    <a class="nav-link" href="../homePage.php">Acceuil</a>
                                    <a class="nav-link" href="../offres/listOffre.php">Offres</a>
                                    <a class="nav-link" href="../entreprise/listEntreprise.php">Entreprises</a>
                              </div>
                        </div>

                        <div class="dropdown">
                              <button class="btn btn-outline-info dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user mx-1"></i>
                                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="../comptes/profil.php">Profil</a></li>
                                    <?php
                                    if ($_SESSION['id'] == 1) {
                                          echo '<li><a class="dropdown-item" href="../admin/adminPage.php">Paramètres</a></li>';
                                    } ?>
                                    <li><a class="dropdown-item" href="../logout.php" class="">Se déconnecter</a></li>
                              </ul>
                        </div>
                  </div>
            </nav>
      </div>

      <div class="container">
            <div class="container-fluid">
                  <?php
                  if ($result = $pdo->query($sql)) {
                        if ($result->rowCount() > 0) {
                              while ($row = $result->fetch()) {
                  ?>
                  <div class="card text-center">
                        <div class="card-header">
                              <h1><?php echo htmlspecialchars($row['Titre']); ?></h1>
                        </div>
                        <div class="card-body">
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Titre</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['Titre'] ?>" disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Durée</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['Durée'] ?>" disabled>
                                    </div>

                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Places</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['nombre_places'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Rémuneration</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['Remuneration'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Date
                                    </label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['Date_post'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Ville
                                    </label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['ville'] ?>" disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Description
                                    </label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $row['descrip'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="card-footer text-muted">
                                    <div class="d-grid gap-2 col-3 mx-auto">
                                          <?php
                                                            if ($_SESSION['id'] == 1 || $_SESSION['id'] == 3) {
                                                                  echo '<a href="postuleForm.php?id=' . $row['id_offre'] . '" class="btn btn-outline-primary btn-sm mb-3">POSTULER</a>';
                                                            } ?>

                                          <a href="listOffre.php" class=" btn btn-outline-info">
                                                <i class=" fa fa-arrow-left">
                                                </i> Liste des offres
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </div>

                  <?php }
                        } else {
                              echo 'Erreur de données, Veuillez contacter un administrateur';
                              echo '<div class="card-footer text-muted"><a href="listOffre.php" class="btn btn-info"><i class=" fa fa-arrow-left">
                              </i>Retourner</a></div>';
                        }
                  } // Free result set
                  unset($result);
                  ?>
            </div>
      </div>

      <script src="../../assets/vendors/jquery/jquery-3.6.0.min.js"></script>
      <script src="../../assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>