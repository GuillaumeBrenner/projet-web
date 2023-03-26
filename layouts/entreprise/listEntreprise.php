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
                                    <a class="nav-link active" href="#">Entreprises</a>
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
            <div class="container-fluid">
                  <div class="row">
                        <div class="col-12">
                              <h1>Liste des Entreprises</h1>
                              <div class="mt-5 mb-3">
                                    <h2 class="pull-left">
                                          <?php

                                          if ($_SESSION['id'] == 1 || $_SESSION['id'] == 4) {
                                                echo '<a href="createEntreprise.php" class="btn btn-primary"><i
                                                      class="fa fa-plus"></i>
                                                Créer une entreprise</a>';
                                          } ?>
                                    </h2>
                              </div>
                        </div>
                        <?php
                        // Include config file
                        require_once "../../config.php";

                        // Attempt select query execution
                        $sql = "SELECT * FROM entreprise";
                        if ($result = $pdo->query($sql)) {
                              if ($result->rowCount() > 0) {
                                    echo '<div class="col-md-12">';
                                    echo '<table id="dataList" class="table table-bordered table-striped">';
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>Nom de l'entreprise</th>";
                                    echo "<th>Nombre d'étudiants</th>";
                                    echo "<th>Action</th>";
                                    echo "<th></th>";
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while ($row = $result->fetch()) {
                                          echo "<tr>";
                                          echo "<td>" . $row['id_entreprise'] . "</td>";
                                          echo "<td>" . $row['nom'] . "</td>";
                                          echo "<td>" . $row['nombre_etudiant'] . "</td>";
                                          echo "<td>";
                                          echo '<a href="viewEnt.php?id=' . $row['id_entreprise'] . '" title="Voir" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                          if ($_SESSION['id'] == 1 || $_SESSION['id'] == 4) {
                                                echo '<a href="update.php?id=' . $row['id_entreprise'] . '" class="ms-3" title="Modifier" data-toggle="tooltip" data-bs-toggle="modal"
                                                      data-bs-target="#Modifier" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                                echo '<a href="#" class="ms-3 deletebtn"><span class="fa fa-trash"></span></a>';
                                          }
                                          echo '<a href="delete.php?id=' . $row['id_entreprise'] . '" title="Statistique" class="ms-3"><span class="fa fa-signal"></span></a>';
                                          echo "</td>";
                                          echo "<td>";
                                          echo '<a href="delete.php?id=' . $row['id_entreprise'] . '" class="btn btn-outline-primary btn-sm">EVALUER</a>';
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

                  $('#id_entreprise').val(data[0]);

            });
      });
      </script>



</body>

</html>

<div class="modal fade" id="Modifier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <input type="hidden" name="delete_id" id="id_entreprise">
                              <h4>Voulez-vous vraiment supprimer cette entreprise?</h4>
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