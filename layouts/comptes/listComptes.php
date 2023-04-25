<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if ($_SESSION["id"] !== 1 || $_SESSION["loggedin"] !== true) {
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
      <title>Liste des Comptes</title>
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../../style.css" type="text/css" />

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
</head>

<body>
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
                                          <li><a class="dropdown-item" href="./profil.php">Profil</a></li>
                                          <?php
                                          if ($_SESSION['id'] == 1) {
                                                echo '<li><a class="dropdown-item" href="../admin/adminPage.php">Paramètres</a></li>';
                                          } ?>
                                          <li><a class="dropdown-item" href="../logout.php" class="">Se déconnecter</a>
                                          </li>
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
                                          <h1>Liste des Comptes</h1>
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
                                                      <!-- <div class="dropdown mb-3">
                                                            <button class="btn btn-secondary dropdown-toggle"
                                                                  type="button" data-bs-toggle="dropdown"
                                                                  aria-expanded="false">
                                                                  Profil
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                  <li><a class="dropdown-item" href="#">Pilotes</a></li>
                                                                  <li><a class="dropdown-item" href="#">Etudiants</a>
                                                            </ul>
                                                      </div>
                                                 -->
                                                </h2>
                                                <?php

                                                if ($_SESSION['id'] == 1) {
                                                      echo '<a href="" class="btn btn-primary pull-left mb-3" data-toggle="tooltip" data-bs-toggle="modal"
                                                      data-bs-target="#choiceModal"><i
                                                      class="fa fa-plus"></i>
                                                Créer un compte</a>';
                                                      echo '<div class="modal-dialog modal-dialog-centered">
                                              </div>';
                                                } ?>

                                          </div>
                                    </div>
                                    <?php
                                    // Include config file
                                    require_once "../../config.php";

                                    // Attempt select query execution
                                    $sql = "SELECT compte.id_c, personne.id_personne, personne.Nom , personne.Prenom , personne.sexe,personne.mail,
                                     type_compte.type, compte.id_type 
                                    FROM compte 
                                    INNER JOIN personne ON compte.id_personne = personne.id_personne
                                    INNER JOIN type_compte ON compte.id_type = type_compte.id_type
                                    WHERE validite = 1 AND compte.id_type = 3";
                                    if ($result = $pdo->query($sql)) {
                                          if ($result->rowCount() > 0) {
                                                echo '<div class="col-md-12">';
                                                echo '<table id="dataList" class="table table-bordered table-striped">';
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th>#</th>";
                                                echo "<th>Nom</th>";
                                                echo "<th>Prénom</th>";
                                                echo "<th>Sexe</th>";
                                                echo "<th>Email</th>";
                                                echo "<th>Type de compte</th>";
                                                echo "<th>Action</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";
                                                while ($row = $result->fetch()) {
                                                      echo "<tr>";
                                                      echo "<td>" . $row['id_c'] . "</td>";
                                                      echo "<td>" . $row['Nom'] . "</td>";
                                                      echo "<td>" . $row['Prenom'] . "</td>";
                                                      echo "<td>" . $row['sexe'] . "</td>";
                                                      echo "<td>" . $row['mail'] . "</td>";
                                                      echo "<td>" . $row['type'] . "</td>";
                                                      echo "<td>";
                                                      echo '<a href="viewProfil.php?id=' . $row['id_personne'] . '" title="Details"
                                                      data-bs-target="#compte"><span class="fa fa-eye"></span></a>';
                                                      echo '<a href="#" class="ms-3 editbtn"><span class="fa fa-pencil"></span></a>';
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
            </div>

            <script src="./assets/vendors/jquery/jquery-3.6.0.min.js"></script>
            <script src="./assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Script datatable -->
            <?php
            include '../../datatable.php'
            ?>
      </body>

</html>


<!-- SCRIPT js POUR LA MODIFICATION -->
<script>
$(document).ready(function() {

      $('#dataList').on('click', '.editbtn', function() {

            $('#editCompte').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                  return $(this).text();
            }).get();

            console.log(data);

            $('#id_c').val(data[0]);
            $('#Nom').val(data[1]);
            $('#Prenom').val(data[2]);
            $('#sexe').val(data[3]);
      });
});
</script>

<!-- MODIFICATION DE L'OFFRE MODAL -->
<div class="modal fade" id="editCompte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification de Compte</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="updateCompte.php" method="post">
                        <div class="modal-body">
                              <div class="row">
                                    <input type="hidden" name="id_c" id="id_c">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label">Nom</label>
                                                      <input type="Text" class="form-control" id="Nom" name="Nom">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label">Prénom</label>
                                                      <input type="Text" class="form-control" id="Prenom" name="Prenom">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label">Sexe</label>
                                                      <select class="form-select" name="sexe"
                                                            aria-label="Default Select example">
                                                            <option value="Masculin">Masculin</option>
                                                            <option value="Féminin">Féminin</option>
                                                            <option value="O">Ne se prononce pas</option>
                                                      </select>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label">Email</label>
                                                      <input type="Text" class="form-control" id="mail" name="mail">
                                                </div>
                                          </div>
                                    </div>
                              </div>

                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-outline-danger"
                                    data-bs-dismiss="modal">Annuler</button>
                              <button type="submit" name="updateCompte" class="btn btn-primary">Sauvegarder</button>
                        </div>
                  </form>
            </div>
      </div>
</div>

<!-- SCRIPT js POUR LA SUPPRESSION  -->
<script>
$(document).ready(function() {

      $('#dataList').on('click', '.deletebtn', function() {

            $('#deletemodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                  return $(this).text();
            }).get();

            console.log(data);

            $('#id_c').val(data[0]);

      });
});
</script>

<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="deleteCompte.php" method="post">
                        <div class="modal-body">
                              <input type="hidden" name="id_c" id="id_c">
                              <h4>Voulez-vous vraiment supprimer ce compte?</h4>
                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                              <button type="submit" name="deleteCompte" class="btn btn-danger"> Supprimer
                              </button>
                        </div>
                  </form>
            </div>
      </div>
</div>

<div class="modal fade" id="choiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                  <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                        <a href="createEtudiant.php" type="button" class="btn btn-secondary btn-lg">Etudiant</a>
                  </div>
                  <div class="modal-footer"></div>
            </div>
      </div>
</div>

<!-- MESSAGE DE REUSSITE CREATION (Bootstrap ALERT) -->
<script>
window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
      });
}, 3000);
</script>