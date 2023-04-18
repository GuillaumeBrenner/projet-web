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

$req = "SELECT * from secteur_activité";
$sectSel = $pdo->query($req);
$secteurs = $sectSel->fetchAll(PDO::FETCH_ASSOC);

$req = "SELECT * from ville";
$villeSel = $pdo->query($req);
$villes = $villeSel->fetchAll(PDO::FETCH_ASSOC);
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
      <link rel="stylesheet" href="FormsCSS.css">

</head>

<body>
      <style>
      .profile_img {
            margin-left: 35%;
            width: 40%;
      }
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
                                                            <label for="FormInput" class="form-label Offre">Nom de
                                                                  l'entreprise</label>
                                                            <input type="Text" class="form-control"
                                                                  id="exampleFormControlInput1" name="Nom_entreprise"
                                                                  placeholder="" require>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-6">
                                                <div class="form-group">
                                                      <div class="mb-3">
                                                            <label for="FormInput" class="form-label Offre">Nombre
                                                                  d'etudiants CESI</label>
                                                            <input type="Text" class="form-control"
                                                                  id="exampleFormControlInput1" name="Nombre_etudiants"
                                                                  placeholder="" require>
                                                      </div>
                                                </div>
                                          </div>


                                          <div class="mb-3 Ent">
                                                <img src="\upload\profile_pics\default.png" class="profile_img"
                                                      id="profile_img" alt="Responsive image"> </img>
                                                <input class="form-control form-control-sm inpt" id="image_file"
                                                      type="file" accept="image/*" name="profile_img" />
                                          </div>

                                          <div class="mb-3">
                                                <label for="FormInput" class="form-label Offre">Localité</label>
                                                <div class="mb-3 row">
                                                      <select name="ville[]" class="selectpicker" multiple
                                                            aria-label="Default select example" data-live-search="true">
                                                            <?php
                                                            foreach ($villes as $ville) {
                                                                  echo "<option value='{$ville['ville']}'>{$ville['ville']}</option>";
                                                            }
                                                      ?>
                                                      </select>
                                                </div>
                                          </div>



                                          <div class="mb-3">
                                                <label for="FormInput" class="form-label" id="secAc">Secteur
                                                      d'activité</label>
                                                <div class="mb-3 row">
                                                      <select name="ville[]" class="selectpicker" multiple
                                                            aria-label="Default select example" data-live-search="true">
                                                            <?php
                                                            foreach ($secteurs as $secteur) {
                                                                  echo "<option value='{$secteur['secteur']}'>{$secteur['secteur']}</option>";
                                                            }
                                                      ?>
                                                      </select>
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

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
      </script>
</body>

</html>