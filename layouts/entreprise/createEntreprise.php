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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="FormsCSS.css">
      
</head>

<body>
<style>
            .profile_img{
    margin-left: 35%;
    width: 40%;
}
      </style>
      <?php
            $req = "SELECT * from secteur_activité";
            $sectSel = $pdo->query($req);

            $req = "SELECT * from ville";
            $villeSel = $pdo->query($req);

      ?>
      <div class="container">
            <div class="container mt-5">
                  <div class="card">
                        <h1 class="card-header"> Créer une Entreprise</h1>
                        <div class="card-body">
                              <form action="insertion.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                          <label for="FormInput" class="form-label" id="NbEtu">Nom de
                                                l'entreprise</label>
                                          <input type="text" class="form-control" id="exampleFormControlInput1"
                                                placeholder="" name="Nom_entreprise">
                                    </div>


                                    <div class="mb-3 Ent">
                                    <img src="\upload\profile_pics\default.png" class="profile_img" id="profile_img" alt="Responsive image" > </img>
                                          <input class="form-control form-control-sm inpt" id="image_file" type="file" accept="image/*" name="profile_img"/> 
                                    </div>


                                    <div class="mb-3">
                                          <label for="FormInput" class="form-label">Localité</label>
                                          <div class="row">
                                          <select name="ville[]" class="selectpicker" multiple aria-label="Default select example" data-live-search="true">
                                          <?php
                                                while ($tab = $villeSel->fetch()) {
                                                      $code_postal = $tab[2];
                                                      /* rajoute un zero devant si le code postal est a 4 chiffres */
                                                      if (strlen($code_postal) == 4) {
                                                            $code_postal = '0' . $code_postal;
                                                      }
                                                      echo '<option value="' . $tab[1] . '(' . $code_postal. ')' . '">'  . $tab[1] . '(' . $code_postal. ')' .  '</option>';
                                                }
                                          ?>
                                          </select>
                                          </div>
                                    </div>



                                    <div class="mb-3">
                                          <label for="FormInput" class="form-label" id="secAc">Secteur
                                                d'activité</label>
                                          <select name="secteur[]" class="selectpicker" multiple aria-label="Default select example" data-live-search="true">
                                          <?php
                                                while ($tab = $sectSel->fetch()) {
                                                      echo '<option value="' . $tab[1] .'">'  . $tab[1] .  '</option>';
                                                }
                                          ?>
                                          </select>
                                    </div>


                                    <div class="mb-3">
                                          <label for="FormInput" class="form-label Cent" id="NbEtu">Nombre d'etudiants
                                                CESI</label>
                                          <input type="text" class="form-control" id="exampleFormControlInput1"
                                                placeholder="" name="Nombre_etudiants">
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

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
                  ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size,
                        size, 0, 0, size, size);
                  profile_img.src = canvas.toDataURL('image/jpeg');
            }
      }
});
</script>

</html>