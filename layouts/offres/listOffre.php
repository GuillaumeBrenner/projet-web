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
                              $sql = "SELECT * FROM offre WHERE valide = 1";
                              if ($result = $pdo->query($sql)) {
                                    if ($result->rowCount() > 0) {
                                          echo '<div class="col-md-12">';
                                          echo '<table id="dataList" class="table table-bordered table-striped">';
                                          echo "<thead>";
                                          echo "<tr>";
                                          echo "<th>#</th>";
                                          echo "<th>Titre</th>";
                                          echo "<th>Description</th>";
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
                                                echo "<td>" . $row['descrip'] . "</td>";
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
                                                echo "</td>";

                                                echo "<td>";
                                                if ($_SESSION['id'] == 1 || $_SESSION['id'] == 3) {
                                                echo '<a href="postuleForm.php?id=' . $row['id_offre'] . '" class="btn btn-outline-primary btn-sm mb-3">POSTULER</a>';
                                                      echo '<form action="wishlist.php" method="post">
                                                                  <button type="submit" name="id_offre" value="' . $row['id_offre'] . '" class="btn btn-outline-primary btn-sm">WHISHLIST</button>
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

      <!-- Script datatable -->
      <?php
      include '../../datatable.php'
      ?>

      <script src="./assets/vendors/jquery/jquery-3.6.0.min.js"></script>
      <script src="./assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>

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
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression
                              </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form action="deleteOffre.php" method="post">
                              <div class="modal-body">
                                    <input type="hidden" name="id_o" id="id_o">
                                    <h4>Voulez-vous vraiment supprimer cette offre?</h4>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                          data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" name="deleteOffre" class="btn btn-danger"> Supprimer
                                    </button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

      <!-- SCRIPT js POUR LA MODIFICATION -->
      <script>
      $(document).ready(function() {

            $('#dataList').on('click', '.editbtn', function() {

                  $('#editOffre').modal('show');

                  $tr = $(this).closest('tr');

                  var data = $tr.children("td").map(function() {
                        return $(this).text();
                  }).get();

                  console.log(data);

                  $('#Update_id_offre').val(data[0]);
                  $('#Titre').val(data[1]);
                  $('#descrip').val(data[2]);
                  $('#Durée').val(data[3]);
                  $('#Date_post').val(data[4]);
                  $('#nombre_places').val(data[5]);
                  $('#Rémunération').val(data[6]);
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification de l'offre</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <?php
                  $pdo = new PDO("mysql:host=localhost;dbname=projetWeb", "root", "");
                  $req = "SELECT * from entreprise";
                  $entSelect = $pdo->query($req);

                  ?>
                  <form action="updateOffre.php" method="post">
                        <div class="modal-body">
                              <div class="row">
                                    <input type="hidden" name="id_offre" id="Update_id_offre">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Titre</label>
                                                      <input type="Text" class="form-control" id="Titre" name="Titre">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Entreprise</label>
                                                      <select name="entreprise" id="entreprise" class="form-select"
                                                            aria-label="Default select example" required>
                                                            <?php
                                                            // foreach ($noms as $nom) {
                                                            // echo "<option value='{$nom['id_entreprise']}'>{$nom['nom']}</option>";
                                                            //}
                                                            ?>
                                                            <option value="">Sélectionner l'entreprise</option>
                                                            <?php
                                                            if ($entSelect->rowCount() > 0) {
                                                                  while ($row = $entSelect->fetch()) {
                                                                        echo '<option value="' . $row['id_entreprise'] . '">' . $row['nom'] . '</option>';
                                                                  }
                                                            } else {
                                                                  echo '<option value="">Données Entrepise non disponibles</option>';
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
                                                      <input type="Text" class="form-control" id="Durée" name="Durée">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Rémunération</label>
                                                      <input type="Text" class="form-control" id="Rémunération"
                                                            name="Rémunération">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Date de
                                                            l'Offre</label>
                                                      <input type="date" class="form-control" id="date" name="Date_post"
                                                            placeholder="" required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Nombre de
                                                            places</label>
                                                      <input type="Text" class="form-control" id="nombre_places"
                                                            name="nombre_places">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Description</label>
                                                      <input type="Text" class="form-control" id="descrip"
                                                            name="descrip">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-12">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Site</label>
                                                      <select name="site" id="site" class="form-select"
                                                            aria-label="Default select example" required>
                                                            <option value="">Sélectionner en premier l'entreprise
                                                            </option>
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
            </div>
      </div>
</div>

<!-- 
            SCRIPT JS POUR LE CONTROLE DU SELECT DE L'ENTREPRISE ET DU SITE 
            ON RECUPERE L'ID DE L'ENTREPRISE ET ON FILTRE LE SELECT BOX DU SITE EN FONCTION 
            LE FICHIER CREATEOFFAJAX.PHP PERMET DE RETOURNER LA LISTE DES SITES 
      -->
<script>
$(document).ready(function() {
      $('#entreprise').on('change', function() {
            var id_entreprise = $(this).val();
            if (id_entreprise) {
                  $.ajax({
                        type: 'POST',
                        url: 'createOffAjax.php',
                        data: 'id_entreprise=' + id_entreprise,
                        success: function(html) {
                              $('#site').html(html);
                        }
                  });
            } else {
                  $('#site').html(
                        '<option value="">Selectionner en premier entreprise</option>'
                  );
            }
      });
});
</script>

<!-- 
            SCRIPT JS POUR LE CONTROLE DE LA DATE
            LA VALEUR MIN EST DEFINIE SUR 3 JOURS A PARTIR DE LA DATE COURANTE
            LA VALEUR MAX EST DEFINIE SUR 2 JOURS A PARTIR DE LA DATE COURANTE
      -->
<script>
$(document).ready(function() {
      var minDate = new Date();
      minDate.setDate(minDate.getDate() - 10);
      minDate = minDate.toISOString().split('T')[0];
      document.getElementById('date').setAttribute('min', minDate);

      var maxDate = new Date();
      maxDate.setDate(maxDate.getDate() + 2);
      maxDate = maxDate.toISOString().split('T')[0];
      document.getElementById('date').setAttribute('max', maxDate);
});
</script>