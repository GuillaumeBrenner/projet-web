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
                  <div class="row">
                        <div class="col-12">
                              <h1>Liste des Entreprises</h1>
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
                                                echo '<a href="createEntreprise.php" class="btn btn-primary"><i
                                                      class="fa fa-plus"></i>
                                                Créer une entreprise</a>';
                                          } ?>
                                    </h2>
                              </div>
                        </div>

                        <div class="col-md-12">
                              <table id="dataList" class="table table-striped table-bordered">
                                    <thead>
                                          <tr>
                                                <th>#</th>
                                                <th>Nom de l'entreprise</th>
                                                <th>Etudiants CESI</th>
                                                <th>Actions</th>
                                                <th></th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                          require_once "../../config.php";
                                          // Préparer et exécuter la requête pour récupérer les données de la base de données
                                          $query = 'SELECT * FROM entreprise WHERE validite = 1';
                                          $stmt = $pdo->prepare($query);
                                          $stmt->execute();
                                          $entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                          // Afficher les données dans le DataTable
                                          foreach ($entreprises as $entreprise) {
                                                echo '<tr>';
                                                echo '<td>' . $entreprise['id_entreprise'] . '</td>';
                                                echo '<td>' . $entreprise['nom'] . '</td>';
                                                echo '<td>' . $entreprise['nombre_etudiant'] . '</td>';
                                                echo "<td>";
                                                echo '<a href="viewEnt.php?id=' . $entreprise['id_entreprise'] . '" title="Voir" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                                if ($_SESSION['id'] == 1 || $_SESSION['id'] == 4) {
                                                      echo '<a href="#" class="ms-3 editbtn"><span class="fa fa-pencil"></span></a>';
                                                      echo '<a href="#" class="ms-3 deletebtn"><span class="fa fa-trash"></span></a>';
                                                }
                                                echo "</td>";
                                                echo "<td>";
                                                echo '<a href="evaluer.php?id=' . $entreprise['id_entreprise'] . '" class="btn btn-outline-primary btn-sm">EVALUER</a>';
                                                echo "</td>";
                                                echo '</tr>';
                                          }
                                          ?>
                                    </tbody>
                              </table>
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

      <!-- SCRIPT js POUR LA SUPPRESSION -->
      <!--  script JavaScript pour initialiser DataTables et le modal de confirmation -->
      <script>
      $(document).ready(function() {

            $('#dataList').on('click', '.deletebtn', function() {

                  $('#deletemodal').modal('show');

                  $tr = $(this).closest('tr');

                  var data = $tr.children("td").map(function() {
                        return $(this).text();
                  }).get();

                  console.log(data);

                  $('#id_entreprise').val(data[0]);

            });
      });
      </script>

      <!--MODAL DE SUPPRESSION  -->
      <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation de suppression
                              </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form action="deleteEntreprise.php" method="post">
                              <div class="modal-body">
                                    <input type="hidden" name="id_entreprise" id="id_entreprise">
                                    <h4>Êtes-vous sûr de vouloir supprimer cette entreprise ?</h4>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                          data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" name="deleteEntreprise" class="btn btn-danger">
                                          Supprimer
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

                  $('#editEnt').modal('show');

                  $tr = $(this).closest('tr');

                  var data = $tr.children("td").map(function() {
                        return $(this).text();
                  }).get();

                  console.log(data);

                  $('#Update_id_ent').val(data[0]);
                  $('#nom').val(data[1]);
                  $('#nbr').val(data[2]);
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

<!-- MODIFICATION DE L'ENTREPRISE MODAL -->
<div class="modal fade" id="editEnt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification de l'entreprise</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="updateEnt.php" method="post">
                        <div class="modal-body">
                              <input type="hidden" name="id_entreprise" id="Update_id_ent">
                              <div class="mb-3">
                                    <div class="form-group">
                                          <label class="form-label">Nom de
                                                l'entreprise</label>
                                          <input type="text" class="form-control" id="nom" name="nom">
                                    </div>
                              </div>

                              <!--   <div class="mb-3">
                                    <label for="FormInput" class="form-label">Localité</label>
                                    <div class="row">
                                          <div class="col loc ">
                                                <input type="text" class="form-control mr-1 w-60 "
                                                      id="exampleFormControlInput2" name="localite"
                                                      placeholder="CodePostal">
                                          </div>
                                          <div class="col loc">
                                                <input type="text" class="form-control mr-1 w-60" id="ville"
                                                      name="ville" placeholder="Ville">
                                          </div>
                                          <div class="col loc">
                                                <input type="text" class="form-control mr- w-60"
                                                      id="exampleFormControlInput2" name="Region" placeholder="Region">
                                          </div>
                                    </div>
                              </div> -->

                              <!-- <div class="mb-3">
                                    <label for="FormInput" class="form-label" id="secAc">Secteur
                                          d'activité</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                          name="Secteur_dactivité">
                              </div> -->

                              <div class="mb-3">
                                    <div class="form-group">
                                          <label class="form-label Cent">Nombre d'etudiants
                                                CESI</label>
                                          <input type="text" class="form-control" id="nbr" name="nbr">
                                    </div>
                              </div>

                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-outline-danger"
                                    data-bs-dismiss="modal">Annuler</button>
                              <button type="submit" name="updateSubmit" class="btn btn-primary">Sauvegarder</button>
                        </div>
                  </form>
            </div>
      </div>
</div>