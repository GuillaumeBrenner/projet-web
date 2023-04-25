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
      <title>Liste des Utilisateurs</title>
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
                                          <h1>Liste des utilisateurs du système</h1>
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
                                                <h2 class="pull-left">
                                                      <?php

                                                      if ($_SESSION['id'] == 1) {
                                                            echo '<a href="addUsers.php" class="btn btn-primary"><i
                                                      class="fa fa-plus"></i>
                                                Créer un utilisateur</a>';
                                                      } ?>
                                                </h2>
                                          </div>

                                    </div>
                              </div>

                              <?php
                              // Connexion à la base de données
                              require_once "../../config.php";

                              // Récupération de la liste des utilisateurs 
                              $sql = 'SELECT compte.id_c, personne.id_personne, personne.Nom , personne.Prenom , personne.sexe, personne.mail,
                              type_compte.type, compte.id_type 
                              FROM compte 
                              INNER JOIN personne ON compte.id_personne = personne.id_personne
                              INNER JOIN type_compte ON compte.id_type = type_compte.id_type 
                              WHERE validite = 1 AND compte.id_type IN (1,2,4)';
                              $stmt = $pdo->query($sql);
                              $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                              ?>

                              <table id="dataList" class="table table-bordered table-striped">
                                    <thead>
                                          <tr>
                                                <th>#</th>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Sexe</th>
                                                <th>Email</th>
                                                <th>Type</th>
                                                <th>Changer de Role</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <?php foreach ($utilisateurs as $utilisateur) : ?>
                                          <tr>
                                                <td><?php echo htmlspecialchars($utilisateur['id_c']); ?></td>
                                                <td><?php echo htmlspecialchars($utilisateur['Nom']); ?></td>
                                                <td><?php echo htmlspecialchars($utilisateur['Prenom']); ?></td>
                                                <td><?php echo $utilisateur['sexe']; ?></td>
                                                <td><?php echo $utilisateur['mail']; ?></td>
                                                <td><?php echo $utilisateur['type']; ?></td>
                                                <td>
                                                      <form action="update_role.php" method="post"
                                                            id="form_<?php echo $utilisateur['id_c'] ?>">
                                                            <input type="hidden" name="id_c"
                                                                  value="<?php echo htmlspecialchars($utilisateur['id_c']) ?>">
                                                            <select name="id_type" class="form-control"
                                                                  onchange="confirmer(this)">
                                                                  <option value="1"
                                                                        <?php if ($utilisateur['id_type'] == 1) { echo ' selected'; } ?>>
                                                                        Administrateur</option>
                                                                  <option value="2"
                                                                        <?php if ($utilisateur['id_type'] == 2) { echo ' selected'; } ?>>
                                                                        Professionnel</option>
                                                                  <option value="4"
                                                                        <?php if ($utilisateur['id_type'] == 4) { echo ' selected'; } ?>>
                                                                        Pilote</option>
                                                            </select>
                                                      </form>
                                                </td>
                                                <td>
                                                      <a href="#" class="ms-3 deleteBtn"><span
                                                                  class="fa fa-trash"></span></a>
                                                </td>
                                          </tr>
                                          <?php endforeach; ?>
                                    </tbody>
                              </table>

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



<!-- SCRIPT js POUR LA SUPPRESSION  -->
<script>
$(document).ready(function() {

      $(' #dataList').on('click', '.deleteBtn', function() {
            $('#deletemodal').modal('show');
            $tr = $(this).closest('tr');
            var
                  data = $tr.children("td").map(function() {
                        return
                        $(this).text();
                  }).get();
            console.log(data);
            $('#id_user').val(data[0]);
      });
});
</script>

<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                              Suppression</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="deleteUsers.php" method="post">
                        <div class="modal-body">
                              <input type="hidden" name="id_user" id="id_user">
                              <h4>Voulez-vous
                                    vraiment
                                    supprimer ce
                                    compte?</h4>
                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                              <button type="submit" name="deleteCompte" class="btn btn-danger">
                                    Supprimer
                              </button>
                        </div>
                  </form>
            </div>
      </div>
</div>

<!-- MESSAGE DE REUSSITE CREATION (Bootstrap ALERT) -->
<script>
window.setTimeout(function() {
      $(".alert").fadeTo(500, 0)
            .slideUp(500,
                  function() {
                        $(this)
                              .remove();
                  });
}, 3000);
</script>

<script>
function confirmer(select) {
      if (confirm("Êtes-vous sûr de vouloir attribuer ce rôle à l'utilisateur ?")) {
            var form = select.parentNode;
            form.submit();
      } else {
            var option = select.querySelector("[value=" + select.getAttribute("data-original-value") + "]");
            option.selected = false;
      }
}
</script>