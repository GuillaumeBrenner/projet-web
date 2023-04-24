<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}
// Include config file
require_once "../../config.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Profil</title>
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../../assets/vendors/fontawesome/css/all.min.css" />
      <link rel="stylesheet" href="../../style.css" type="text/css" />

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
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
                                    <i class="fas fa-user mx-1"></i>
                                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Profil</a></li>
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
                  $sql = 'SELECT *
                        FROM personne p
                        INNER JOIN compte c ON p.id_personne = c.id_personne 
                        INNER JOIN etre_promo e ON c.id_c = e.id_c
                        INNER JOIN promotion pr ON e.id_promotion = pr.id_promotion
                        INNER JOIN centre ce ON ce.id_c = c.id_c
                        INNER JOIN ville v ON v.id_ville = ce.id_ville
                        WHERE c.login = "' . $_SESSION["username"] . '"';

                  if ($result = $pdo->query($sql)) {
                        if ($result->rowCount() > 0) {
                              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <div class="card text-center mb-5">
                        <div class="row">
                              <div class="col-md-6">
                                    <img src="<?php echo $row['photo_profil']; ?>" class="img-fluid rounded-start" />
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
                                          <button type="button" class="btn btn-outline-info editbtn"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">Modifier</button>
                                    </div>
                              </div>
                        </div>
                        <?php
                                          if (isset($_SESSION['status'])) {
                                          ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <?php echo $_SESSION['status']; ?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['status']);
                                          } ?>
                        <?php
                                          if (isset($_SESSION['supp'])) {
                                          ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <?php echo $_SESSION['supp']; ?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['supp']);
                                          } ?>
                  </div>

                  <!-- MODIFICATION DE PROFIL MODAL -->
                  <div class="modal fade" id="editProfil" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                    <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel">Modification du profil
                                          </h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form action="updateProfil.php" method="post">
                                          <div class="modal-body">
                                                <div class="row">
                                                      <input type="hidden" name="id_c" id="id_c"
                                                            value="<?= $row['id_c'] ?>">
                                                      <input type="hidden" name="id_p" id="id_p"
                                                            value="<?= $row['id_personne'] ?>">
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <div class="mb-3">
                                                                        <label class="form-label">Nom</label>
                                                                        <input type="Text" class="form-control" id="Nom"
                                                                              name="Nom" value="<?= $row['Nom'] ?>">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <div class="mb-3">
                                                                        <label class="form-label Offre">Prénom</label>
                                                                        <input type="Text" class="form-control"
                                                                              id="Prenom" name="Prenom"
                                                                              value="<?= $row['Prenom'] ?>">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <div class="mb-3">
                                                                        <label class="form-label">Sexe</label>
                                                                        <select class="form-select" name="sexe">
                                                                              <option value="Masculin">Masculin</option>
                                                                              <option value="Féminin">Féminin</option>
                                                                              <option value="O">Ne se prononce pas
                                                                              </option>
                                                                        </select>
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <div class="mb-3">
                                                                        <label class="form-label Offre">Centre</label>
                                                                        <input type="Text" class="form-control"
                                                                              id="centre" name="centre"
                                                                              value="<?= $row['ville'] ?>">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <div class="mb-3">
                                                                        <label class="form-label Offre">Login</label>
                                                                        <input type="Text" class="form-control"
                                                                              id="login" name="login"
                                                                              value="<?= $row['login'] ?>">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <div class="mb-3">
                                                                        <label class="form-label Offre">MDP</label>
                                                                        <input type="password" class="form-control"
                                                                              id="mdp" name="mdp"
                                                                              value="<?= $row['mdp'] ?>">
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-danger"
                                                      data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" name="updateProfil"
                                                      class="btn btn-primary">Sauvegarder</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

                  <?php
                              }
                        }
                  }
                  ?>
            </div>

            <?php if ($_SESSION['id'] == 1 || $_SESSION['id'] == 3) {
            ?>
            <div class="container">
                  <div class="card text-center mb-5">
                        <div class="card-header">
                              <h2>Liste des candidatures</h2>
                        </div>
                        <div class="card-body">
                              <?php
                              // Attempt select query execution
                              $sql = 'SELECT *
                              FROM postule p 
                              INNER JOIN compte c ON c.id_c = p.id_c
                              INNER JOIN offre o ON o.id_offre = p.id_offre
                              WHERE c.login = "' . $_SESSION["username"] . '"';

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
                                                      echo '<td><a target="link" href="' . $data['cv_name'] . '"><button class="btn btn-secondary"><i class="fas fa-download"></i></button></a></td>';
                                                      echo '<td><a target="link" href="' . $data['ldm_name'] . '"><button class="btn btn-secondary"><i class="fas fa-download"></i></button></a></td>';
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
                  </div>
                  <div class="card text-center mb-5">
                        <div class="card-header">
                              <h2>Liste des souhaits</h2>
                        </div>
                        <div class="card-body">
                              <?php
                                    $pdo = new PDO("mysql:host=localhost;dbname=projetWeb", "root", "");
                                    // Attempt select query execution
                                    $req = 'SELECT w.id_offre, o.Titre, o.Date_post, o.Remuneration, o.nombre_places
                              FROM wishlist w
                              INNER JOIN compte c ON c.id_c = w.id_c
                              INNER JOIN offre o ON o.id_offre = w.id_offre
                              WHERE c.login = "' . $_SESSION["username"] . '"';

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
                  </div>
            </div>
            <?php
            }
            ?>
      </div>

      <!-- Script datatable -->
      <?php
      include '../../datatable.php'
      ?>

      <!-- SCRIPT js POUR LA SUPPRESSION  -->
      <script>
      $(document).ready(function() {

            $('.deletebtn').on('click', function() {

                  $('#deletemodal').modal('show');

                  $tr = $(this).closest('tr');

                  var data = $tr.children("td").map(
                        function() {
                              return $(this).text();
                        }).get();

                  console.log(data);

                  $('#id_o').val(data[0]);

            });
      });
      </script>

      <!--MODAL DE SUPPRESSION  -->
      <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Suppression
                              </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form action="deleteWish.php" method="post">
                              <div class="modal-body">
                                    <input type="hidden" name="id_o" id="id_o">
                                    <h4>Voulez-vous vraiment retirer cette offre de
                                          la liste?</h4>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                          data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" name="deleteOffre" class="btn btn-danger"> Retirer
                                    </button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

      <!-- SCRIPT js POUR LA MODIFICATION DU PROFIL-->
      <script>
      $(document).ready(function() {
            $('.editbtn').on('click', function() {
                  $('#editProfil').modal('show');
            });
      });
      </script>
</body>

</html>

<!-- MESSAGE DE REUSSITE CREATION (Bootstrap ALERT) -->
<script>
window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
      });
}, 3000);
</script>