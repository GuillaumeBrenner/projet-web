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
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Création Offre</title>
      <link rel="stylesheet" href="../../assets/vendors/fontawesome/css/all.min.css">
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
            integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

      <style>
      .profile_img {
            margin-left: 35%;
            width: 40%;
      }
      </style>
      <div class="container mt-5">
            <div class="card">
                  <h1 class="Offre card-header"> Créer un pilote</h1>
                  <?php
                  $req = "SELECT * from entreprise";
                  $entSel = $pdo->query($req);

                  $req = "SELECT * from ville";
                  $villeSel = $pdo->query($req);

                  $req = "SELECT * from promotion";
                  $promoSel = $pdo->query($req);

                  if ($entSel && $villeSel && $promoSel) {

                  ?>
                  <div class="card-body">
                        <form action="insertPilote.php" method="post" enctype="multipart/form-data">
                              <div class="row">
                                    <input type="hidden" name="id_type" id="id_type">
                                    <div class="col-md-6">
                                          <label class="form-label" id="civilite">Civilité</label><br>
                                          <div class="rdiomme">
                                                <input class="form-check-input form-label" type="radio" name="sexe"
                                                      id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                      Mme
                                                </label>
                                          </div>
                                          <div class="rdiom">
                                                <input class="form-check-input form-label" type="radio" name="sexe"
                                                      id="flexRadioDefault2">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                      M
                                                </label>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <label for="FormInput" class="form-label Offre">Photo de profil
                                          </label>
                                          <img src=".\upload\profile_pics\default.png" class="profile_img"
                                                id="profile_img" alt="Responsive image"> </img>
                                          <input class="form-control form-control-sm inpt" id="image_file" type="file"
                                                accept="image/*" name="profile_img" />
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Nom
                                                      </label>
                                                      <input type="text" class="form-control" id="nom" name="nom"
                                                            placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Prenom
                                                      </label>
                                                      <input type="text" class="form-control" id="prenom" name="prenom"
                                                            placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="Description" class="form-label Offre">Login</label>
                                                      <input type="Text" class="form-control Description" id="login"
                                                            name="login" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput Description" class="form-label Offre">Mot de
                                                            passe</label>
                                                      <input type="Text" class="form-control Description"
                                                            id="mdp multiple-select-field" name="mdp" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                          <div class="form-group">
                                                <label class="form-label" id="promo">Promotion</label>
                                                <select name="promo[]" id="SelectPromo" class="selectpicker" multiple
                                                      aria-label="Default select example">
                                                      <?php
                                                                  while ($tab = $promoSel->fetch()) {
                                                                        echo '<option value="' . $tab[0] . '">' . $tab[1] . ' ' . $tab[2] . '</option>';
                                                                  }
                                                                  ?>
                                                </select>
                                          </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                          <label class="form-label">Site</label>
                                          <div class="row">
                                                <div class="mb-3">
                                                      <input class="form-control" list="datalistOptions"
                                                            id="exampleDataList" name="ville"
                                                            placeholder="Commencez à ecrire...">
                                                      <datalist id="datalistOptions">
                                                            <?php
                                                                  while ($tab = $villeSel->fetch()) {
                                                                        $code_postal = $tab[2];
                                                                        /* rajoute un zero devant si le code postal est a 4 chiffres */
                                                                        if (strlen($code_postal) == 4) {
                                                                              $code_postal = '0' . $code_postal;
                                                                        }
                                                                        echo '<option value="' . $tab[1] . '(' . $code_postal. ')' . '">'  . '</option>';
                                                                  }
                                                            ?>
                                                      </datalist>
                                                </div>
                                          </div>
                                    </div>

                              </div>
                              <button type="submit" name="insertEtudiant" class="btn btn-primary">Soumettre</button>
                              <a href="listComptes.php" class="btn btn-outline-danger">Annuler</a>

                        </form>
                  </div>
                  <?php
                  } ?>
            </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
            integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>
      img_file = document.getElementById("image_file");
      profile_img = document.getElementById("profile_img");

      img_file.addEventListener("change", function() {
            let file = this.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function(event) {
                  let img = new Image();
                  img.src = event.target.result;
                  img.onload = function() {
                        let canvas = document.createElement('canvas');
                        let size = Math.min(img.width, img.height);
                        canvas.width = size;
                        canvas.height = size;
                        let ctx = canvas.getContext('2d');
                        ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2,
                              size, size, 0, 0, size, size);
                        profile_img.src = canvas.toDataURL('image/jpeg');
                  }
            }


      });
      </script>


</body>

</html>