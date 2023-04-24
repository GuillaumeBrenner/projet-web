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

      <style>
      .img-fluid {
            max-width: 40%;
            height: auto;
      }
      </style>
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
                  require_once "../../config.php";
                  if (isset($_GET['id'])) {
                        $sql = 'SELECT entreprise.id_entreprise, entreprise.logo, entreprise.nom, entreprise.nombre_etudiant,
                        ville.région, ville.ville, ville.code_postal,
                        secteur_activité.secteur,
                        GROUP_CONCAT(DISTINCT ville.ville SEPARATOR ", ") AS ville, 
                        GROUP_CONCAT(DISTINCT ville.région SEPARATOR ", ") AS région, 
                        GROUP_CONCAT(DISTINCT ville.code_postal SEPARATOR ", ") AS code_postal, 
                        GROUP_CONCAT(DISTINCT secteur_activité.secteur SEPARATOR ", ") AS secteur
                        FROM entreprise INNER JOIN avoir ON entreprise.id_entreprise = avoir.id_entreprise 
                        INNER JOIN secteur_activité ON avoir.id_secteur = secteur_activité.id_secteur 
                        INNER JOIN site ON entreprise.id_entreprise = site.id_entreprise 
                        INNER JOIN ville ON ville.id_ville = site.id_ville 
                        WHERE entreprise.id_entreprise = "' . $_GET['id'] . '"';
                  }
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($entreprises as $entreprise) {

                  ?>

                  <div class="card text-center">
                        <div class="card-header">
                              <h1><?php echo htmlspecialchars($entreprise['nom']); ?></h1>
                        </div>
                        <div class="card-body">
                              <div class="card-header">
                                    <img src="<?php echo $entreprise['logo'] ?>" class="img-thumbnail img-fluid"
                                          alt="Logo entreprise <?php echo $entreprise['nom'] ?>" />
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Nom</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $entreprise['nom'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Nombre
                                          d'étudiants CESI</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text"
                                                value="<?= $entreprise['nombre_etudiant'] ?>" disabled>
                                    </div>

                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Régions</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $entreprise['région'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Villes</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $entreprise['ville'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Code
                                          Postal
                                    </label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text"
                                                value="<?= $entreprise['code_postal'] ?>" disabled>
                                    </div>
                              </div>
                              <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Secteurs d'activité</label>
                                    <div class="col-sm-10">
                                          <input class="form-control" type="text" value="<?= $entreprise['secteur'] ?>"
                                                disabled>
                                    </div>
                              </div>
                              <div class="card-footer text-muted">
                                    <div class="d-grid gap-2 col-3 mx-auto">
                                          <a href="evaluer.php?id= <?= $entreprise['id_entreprise']  ?>"
                                                class="btn btn-outline-primary btn-sm">EVALUER</a>

                                          <a href=" listEntreprise.php" class=" btn btn-outline-info"><i
                                                      class=" fa fa-arrow-left"></i> Liste des entreprises</a>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <?php
                  }
                  ?>
            </div>
      </div>

      <script src=" ../../assets/vendors/jquery/jquery-3.6.0.min.js"></script>
      <script src="../../assets/vendors/bootstrap/js/bootstrap.bundle.min.js">
      </script>
</body>

</html>