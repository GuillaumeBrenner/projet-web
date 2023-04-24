<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0 " />
      <title>Profil</title>
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../../assets/vendors/fontawesome/css/all.min.css" />
      <link rel="stylesheet" href="../../style.css" type="text/css" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
      </script>
</head>

<body>

      <!-- Navbar -->
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

      <div class="bg-secondary">
            <div class="container">
                  <?php
                  require_once "../../config.php";
                  if (isset($_GET['id'])) {
                        $sql = "SELECT *
                        FROM personne p
                        INNER JOIN compte c ON p.id_personne = c.id_personne 
                        INNER JOIN etre_promo e ON c.id_c = e.id_c
                        INNER JOIN promotion pr ON e.id_promotion = pr.id_promotion
                        INNER JOIN centre ce ON ce.id_c = c.id_c
                        INNER JOIN ville v ON v.id_ville = ce.id_ville
                        WHERE p.id_personne = " . $_GET['id'];
                  }
                  if ($result = $pdo->query($sql)) {
                        if ($result->rowCount() > 0) {
                              while ($row = $result->fetch()) {
                  ?>
                  <div class="card text-center mb-5">
                        <div class="row">
                              <div class="col-md-6">
                                    <img src="<?php echo $row['photo_profil'] ?>" class="img-fluid rounded-start" />
                              </div>
                              <div class="col-md-6">
                                    <div class="card-body">
                                          <h1><?= $row['Nom'] ?> <?= $row['Prenom'] ?></h1>
                                          <h2>
                                                Centre : <?= $row['ville'] ?>
                                          </h2>
                                          <h2 class="card-text">
                                                Promotion : <?= $row['nom_promo'] ?>
                                          </h2>
                                    </div>
                              </div>
                        </div>
                  </div>

                  <div class="card text-center mb-5">
                        <div class="card-body">
                              <div class="row">
                                    <div class="col-12">
                                          <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#ModificationProfil">Modifier le profil</button>
                                    </div>
                              </div>
                        </div>
                        <div class="card-body">
                              <div class="row">
                                    <?php if ($_SESSION['id'] == 4) {
                                                            echo ' <div class="col-12">
                                          <a href="listEtudiant.php" class=" btn btn-outline-info">
                                          <i class=" fa fa-arrow-left"></i>Retourner</a></div>';
                                                      } ?>
                                    <?php
                                                      if ($_SESSION['id'] == 1) {
                                                            echo '<div class="col-12">
                                          <a href="listComptes.php" class=" btn btn-outline-info">
                                          <i class=" fa fa-arrow-left"></i>Retourner</a></div>';
                                                      } ?>
                              </div>
                        </div>
                  </div>
                  <?php }

                              ?>

                  <div class="card text-center mb-5">
                        <div class="card-header">
                              <h2>Liste des candidatures</h2>
                        </div>
                        <div class="card-body">
                              <?php
                                          // Attempt select query execution
                                          $sql = "SELECT *
                              FROM postule p 
                              INNER JOIN compte c ON c.id_c = p.id_c
                              INNER JOIN personne pe ON pe.id_personne = c.id_personne
                              INNER JOIN offre o ON o.id_offre = p.id_offre
                              WHERE pe.id_personne =  " . $_GET['id'];

                                          if ($result = $pdo->query($sql)) {
                                                if ($result->rowCount() > 0) {
                                                      echo '<div class="col-md-12">';
                                                      echo '<table id="dataList" class="table table-bordered table-striped">';
                                                      echo "<thead>";
                                                      echo "<tr>";
                                                      echo "<th>#</th>";
                                                      echo "<th>Titre</th>";
                                                      echo "<th>Date</th>";
                                                      echo "<th>Rémunération</th>";
                                                      echo "<th>Nombre de places</th>";
                                                      echo "<th>CV</th>";
                                                      echo "<th>Lettre de motivation</th>";
                                                      echo "</tr>";
                                                      echo "</thead>";
                                                      echo "<tbody>";
                                                      while ($data = $result->fetch()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $data['id_offre'] . "</td>";
                                                            echo "<td>" . $data['Titre'] . "</td>";
                                                            echo "<td>" . $data['Date_post'] . "</td>";
                                                            echo "<td>" . $data['Remuneration'] . "</td>";
                                                            echo "<td>" . $data['nombre_places'] . "</td>";
                                                            echo '<td><a href="' . $data['cv_name'] . '">télécharger</a></td>';
                                                            echo '<td><a href="' . $data['ldm_name'] . '">télécharger</a></td>';
                                                            echo "</tr>";
                                                      }
                                                      echo "</tbody>";
                                                      echo "</table>";
                                                      echo "</div>";
                                                      // Free result set
                                                      unset($result);
                                                } else {
                                                      echo '<div class="alert alert-danger"><em>Aucune donnée</em></div>';
                                                }
                                          } else {
                                                echo "Oops! Réessayer plus tard.";
                                          }
                                          // Close connection
                                          unset($pdo);
                                          ?>
                        </div>
                        <div class="card-footer text-muted"></div>
                  </div>
                  <div class="card text-center mb-5">
                        <div class="card-header">
                              <h2>Liste des souhaits</h2>
                        </div>
                        <div class="card-body">
                              <?php
                                          $pdo = new PDO("mysql:host=localhost;dbname=projetWeb", "root", "");
                                          // Attempt select query execution
                                          $req = "SELECT w.id_offre, o.Titre, o.Date_post, o.Remuneration, o.nombre_places
                              FROM wishlist w
                              INNER JOIN compte c ON c.id_c = w.id_c
                              INNER JOIN personne pe ON pe.id_personne = c.id_personne
                              INNER JOIN offre o ON o.id_offre = w.id_offre
                              WHERE pe.id_personne =  " . $_GET['id'];

                                          if ($data = $pdo->query($req)) {
                                                if ($data->rowCount() > 0) {
                                                      echo '<div class="col-md-12">';
                                                      echo '<table id="dataList" class="table table-bordered table-striped">';
                                                      echo "<thead>";
                                                      echo "<tr>";
                                                      echo "<th>#</th>";
                                                      echo "<th>Titre</th>";
                                                      echo "<th>Date</th>";
                                                      echo "<th>Rémunération</th>";
                                                      echo "<th>Nombre de places</th>";
                                                      echo "<th>Action</th>";
                                                      echo "</tr>";
                                                      echo "</thead>";
                                                      echo "<tbody>";
                                                      while ($row = $data->fetch()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row['id_offre'] . "</td>";
                                                            echo "<td>" . $row['Titre'] . "</td>";
                                                            echo "<td>" . $row['Date_post'] . "</td>";
                                                            echo "<td>" . $row['Remuneration'] . "</td>";
                                                            echo "<td>" . $row['nombre_places'] . "</td>";
                                                            echo "<td>";
                                                            echo '<a href="../offres/viewOffre.php?id=' . $row['id_offre'] . '" title="Details"
                                                data-bs-target="#compte"><span class="fa fa-eye"></span></a>';
                                                            echo '<a href="#" class="ms-3 deletebtn"><span class="fa fa-trash"></span></a>';
                                                            echo "</td>";
                                                            echo "</tr>";
                                                      }
                                                      echo "</tbody>";
                                                      echo "</table>";
                                                      echo "</div>";
                                                      // Free result set
                                                      unset($result);
                                                } else {
                                                      echo '<div class="alert alert-danger"><em>Aucune donnée</em></div>';
                                                }
                                          } else {
                                                echo "Oops! Réessayer plus tard.";
                                          }
                                          // Close connection
                                          unset($pdo);
                                          ?>
                        </div>
                        <div class="card-footer text-muted"></div>
                  </div>
            </div>
            <?php }
                  } else {
                        echo 'Erreur de données, Veuillez contacter un administrateur';
                        echo '<div class="card-footer text-muted"><a href="listComptes.php" class="btn btn-primary">Retourner</a></div>';
                  }

                  // Free result set
                  unset($result);
?>
      </div>


      <script src="./assets/vendors/jquery/jquery-3.6.0.min.js"></script>
      <script src="./assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<div class="modal fade" id="ModificationProfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification du profil</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                        ...
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Sauvegarder</button>
                  </div>
            </div>
      </div>
</div>