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
      <meta name="viewport" content="width=device-width, initial-scale=1.0 " />
      <title>Liste des offres</title>
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
                                    <a class="nav-link active" href="#">Offres</a>
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

      <div class="container">
            <div class="wrapper">
                  <div class="container-fluid">
                        <div class="row">
                              <div class="col-12">
                                    <h1>Liste des Offres</h1>
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

                                    <div class="mt-5 mb-3">
                                          <h2 class="pull-left">
                                                <?php

                                                if ($_SESSION['id'] == 1 || $_SESSION['id'] == 4) {
                                                      echo '<a href="createOffre.php" class="btn btn-primary"><i
                                                      class="fa fa-plus"></i>
                                                Créer une offre</a>';
                                                } ?>
                                          </h2>
                                    </div>
                              </div>
                              <?php
                              // Attempt select query execution
                              $sql = "SELECT * FROM offre";
                              if ($result = $pdo->query($sql)) {
                                    if ($result->rowCount() > 0) {
                                          echo '<div class="col-md-12">';
                                          echo '<table id="dataList" class="table table-bordered table-striped">';
                                          echo "<thead>";
                                          echo "<tr>";
                                          echo "<th>#</th>";
                                          echo "<th>Titre</th>";
                                          echo "<th>Durée</th>";
                                          echo "<th>Date</th>";
                                          echo "<th>Nombre de place</th>";
                                          echo "<th>Rémunération</th>";
                                          echo "<th>Action</th>";
                                          echo "<th></th>";
                                          echo "</tr>";
                                          echo "</thead>";
                                          echo "<tbody>";
                                          while ($row = $result->fetch()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['id_offre'] . "</td>";
                                                echo "<td>" . $row['Titre'] . "</td>";
                                                echo "<td>" . $row['Durée'] . "</td>";
                                                echo "<td>" . $row['Date_post'] . "</td>";
                                                echo "<td>" . $row['nombre_places'] . "</td>";
                                                echo "<td>" . $row['Remuneration'] . "</td>";
                                                echo "<td>";
                                                echo '<a href="viewOffre.php?id=' . $row['id_offre'] . '" title="Voir" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                                if ($_SESSION['id'] == 1 || $_SESSION['id'] == 4) {
                                                      echo '<a href="#" class="ms-3 editbtn"><span class="fa fa-pencil"></span></a>';
                                                      echo '<a href="#" class="ms-3 deletebtn"><span class="fa fa-trash"></span></a>';
                                                }
                                                echo '<a href="delete.php?id=' . $row['id_offre'] . '" title="Statistique" class="ms-3"><span class="fa fa-signal"></span></a>';
                                                echo "</td>";

                                                echo "<td>";
                                                if ($_SESSION['id'] == 1 || $_SESSION['id'] == 3) {
                                                      echo '<form action="Postuler.php" method="post">
                                                                  <button type="submit" name="id_offre" value="' . $row['id_offre'] . '" class="btn-link">POSTULER</button>
                                                            </form>';
                                                      echo '<form action="wishlist.php" method="post">
                                                                  <button type="submit" name="id_offre" value="' . $row['id_offre'] . '" class="btn-link">WHISHLIST</button>
                                                            </form>';
                                                }
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
      </div>

      <?php
      include '../footer.php';
      ?>
      <!-- Script datatable -->
      <?php
      include '../../datatable.php'
      ?>

      <script src="./assets/vendors/jquery/jquery-3.6.0.min.js"></script>
      <script src="./assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- SCRIPT js POUR LA SUPPRESSION -->
      <script>
      $(document).ready(function() {

            $('.deletebtn').on('click', function() {

                  $('#deletemodal').modal('show');

                  $tr = $(this).closest('tr');

                  var data = $tr.children("td").map(function() {
                        return $(this).text();
                  }).get();

                  $('#id_offre').val(data[0]);

            });
      });
      </script>

      <!-- SCRIPT js POUR LA MODIFICATION -->
      <script>
      $(document).ready(function() {

            $('.editbtn').on('click', function() {

                  $('#editOffre').modal('show');

                  $tr = $(this).closest('tr');

                  var data = $tr.children("td").map(function() {
                        return $(this).text();
                  }).get();

                  console.log(data);

                  $('#id_offre').val(data[0]);
                  $('#Titre').val(data[1]);
                  $('#entreprise').val(data[2]);
                  $('#Durée_de_Stage').val(data[3]);
                  $('#Nombre_de_places').val(data[4]);
                  $('#Rémunération').val(data[5]);
                  $('#Date_offre').val(data[6]);
            });
      });
      </script>

      <!-- MESSAGE DE REUSSITE CREATION (Bootstrap ALERT) -->
      <script>
      window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                  $(this).remove();
            });
      }, 3000);
      </script>


</body>

</html>


<!-- MODIFICATION DE L'OFFRE MODAL -->
<div class="modal fade" id="editOffre" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification du profil</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <?php
                  $pdo = new PDO("mysql:host=localhost;dbname=projetWeb", "root", "");
                  $req = "SELECT * from entreprise";
                  $entSel = $pdo->query($req);

                  $req = "SELECT * from ville";
                  $villeSel = $pdo->query($req);

                  if ($entSel && $villeSel) {

                  ?>
                  <form action="updateOffre.php" method="post">
                        <div class="modal-body">
                              <div class="row">
                                    <input type="hidden" name="id_offre" id="id_offre">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Titre</label>
                                                      <input type="Text" class="form-control" id="Titre" name="Titre"
                                                            placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Nom
                                                            Entreprise</label>
                                                      <select name="entreprise" id="SelectEntreprise"
                                                            class="form-select" aria-label="Default select example">
                                                            <?php
                                                                  while ($tab = $entSel->fetch()) {
                                                                        echo '<option selected>Entreprises</option>';
                                                                        echo '<option value="' . $tab[0] . '">' . $tab[1] . ' ' . $tab[2] . '</option>';
                                                                  }
                                                                  ?>
                                                      </select>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Durée de
                                                            Stage</label>
                                                      <input type="Text" class="form-control" id="Durée_de_Stage"
                                                            name="Durée_de_Stage" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Rémunération</label>
                                                      <input type="Text" class="form-control" id="Rémunération"
                                                            name="Rémunération" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Date de
                                                            l'Offre</label>
                                                      <input type="date" class="form-control" id="Date_offre"
                                                            name="Date_offre" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Nombre de
                                                            places</label>
                                                      <input type="Text" class="form-control" id="Nombre_de_places"
                                                            name="Nombre_de_places" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Description</label>
                                                      <input type="Text" class="form-control Description"
                                                            id="competences" name="competences" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="mb-3">
                                          <label for="FormInput" class="form-label Offre">Site</label>
                                          <div class="row">
                                                <div class="mb-3">
                                                      <select name="ville" id="SelectVille" class="form-select"
                                                            aria-label="Default select example">
                                                            <?php
                                                                        while ($tab = $villeSel->fetch()) {
                                                                              echo '<option selected>Ville</option>';
                                                                              echo '<option value="' . $tab[0] . '">' . $tab[1] . ' ' . $tab[2] . '</option>';
                                                                        }
                                                                        ?>
                                                      </select>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-outline-danger"
                                    data-bs-dismiss="modal">Annuler</button>
                              <button type="submit" name="updateOffre" class="btn btn-primary">Sauvegarder</button>
                        </div>
                  </form>
                  <?php  } ?>
            </div>
      </div>
</div>

<!--MODAL DE SUPPRESSION  -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="delete.php" method="POST">
                        <div class="modal-body">
                              <input type="hidden" name="delete_id" id="id_offre">
                              <h4>Voulez-vous vraiment supprimer cette offre?</h4>
                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                              <button type="submit" name="deletedata" class="btn btn-danger"> Supprimer
                              </button>
                        </div>
                  </form>
            </div>
      </div>
</div>