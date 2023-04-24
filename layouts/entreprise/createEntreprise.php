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
<html lang="en">

<head>

      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CréationEntreprise</title>
      <link rel="stylesheet" href="../../assets/vendors/fontawesome/css/all.min.css">
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css">

      <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

      <style>
      .profile_img {
            margin-left: 35%;
            width: 40%;
      }

      .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 100%;
      }
      </style>

</head>

<body>
      <style>

      </style>

      <div class="container">
            <div class="container mt-5">
                  <div class="card">
                        <h1 class="card-header"> Créer une Entreprise</h1>
                        <div class="card-body">
                              <form action="insertion.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                          <div class="col-md-6">
                                                <div class="form-group">
                                                      <div class="mb-3">
                                                            <label for="FormInput" class="form-label">Nom de
                                                                  l'entreprise</label>
                                                            <input type="Text" class="form-control" id="nom" name="nom"
                                                                  required>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-6">
                                                <div class="form-group">
                                                      <div class="mb-3">
                                                            <label for="FormInput" class="form-label">Nombre
                                                                  d'etudiants CESI</label>
                                                            <input type="Text" class="form-control" id="nbr" name="nbr"
                                                                  required>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-12">
                                                <label for="FormInput" class="form-label">Localité</label>
                                                <div class="form-group">
                                                      <div class="mb-3">
                                                            <select name="villes[]" class="selectpicker" multiple
                                                                  data-live-search="true">
                                                                  <?php
                                                                  $sql = "SELECT * from ville";
                                                                  $result = $pdo->query($sql);
                                                                  foreach ($result as $ville) {
                                                                        echo "<option value=" .$ville['id_ville'] . ">{$ville['ville']}</option>";
                                                                  }
                                                                  ?>
                                                            </select>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-12">
                                                <div class="form-group">
                                                      <label for="FormInput" class="form-label">Secteur
                                                            d'activité</label>
                                                      <div class="mb-3">
                                                            <select name="secteurs[]" class="selectpicker" multiple
                                                                  data-live-search="true">
                                                                  <?php
                                                                  $sql = "SELECT * from secteur_activité";
                                                                  $result = $pdo->query($sql);
                                                                  foreach ($result as $secteur) {
                                                                        echo "<option value=" . $secteur['id_secteur'] . ">{$secteur['secteur']}</option>";
                                                                  }
                                                                  ?>
                                                            </select>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                      <label for="file" class="form-label">Logo</label>
                                                      <img src="..\comptes\uploads\profile_pics\default.png"
                                                            class="profile_img" id="profile_img" alt="">
                                                      </img>
                                                      <input type="file" id="logo" name="logo" class="form-control"
                                                            required>
                                                </div>
                                          </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary">Soumettre</button>
                                    <a href="listEntreprise.php" class="btn btn-outline-danger">Annuler</a>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
      <!-- <script>
            $(document).ready(function() {

            $('select').selectpicker();

            });
            </script>
      -->
</body>

</html>