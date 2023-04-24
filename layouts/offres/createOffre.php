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

$req = "SELECT * from entreprise";
$entSelect = $pdo->query($req);
//$noms = $entSelect->fetchAll(PDO::FETCH_ASSOC);

//$req = "SELECT * from ville";
//$villeSel = $pdo->query($req);
//$villes = $villeSel->fetchAll(PDO::FETCH_ASSOC);
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
      <!-- <style>
            .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: none;
            /* Cacher le spinner par défaut */
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -60px;
            margin-left: -60px;
            }

            @keyframes spin {
            0% {
            transform: rotate(0deg);
            }

            100% {
            transform: rotate(360deg);
            }
            }
            </style> -->
</head>

<body>
      <div class="container mt-5">
            <div class="card">
                  <h1 class="Offre card-header"> Créer une Offre</h1>

                  <div class="card-body">
                        <form action="insertion.php" method="post">
                              <div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Titre de
                                                            l'offre</label>
                                                      <input type="Text" class="form-control"
                                                            id="exampleFormControlInput1" name="Titre" required>
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
                                                      <label for="FormInput" class="form-label Offre">Durée de
                                                            Stage</label>
                                                      <input type="Text" class="form-control"
                                                            id="exampleFormControlInput1" name="Durée" required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput"
                                                            class="form-label Offre">Rémunération</label>
                                                      <input type="Text" class="form-control"
                                                            id="exampleFormControlInput1" name="Rémunération"
                                                            placeholder="">
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
                                                      <label for="FormInput" class="form-label Offre">Nombre de
                                                            places</label>
                                                      <input type="Text" class="form-control"
                                                            id="exampleFormControlInput1" name="nombre_places" required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput Description"
                                                            class="form-label Offre">Description</label>
                                                      <input type="Text" class="form-control Description"
                                                            id="exampleFormControlInput1" name="Description" required>
                                                </div>
                                          </div>
                                    </div>

                                    <!--  <div class="mb-3">
                                          <label for="FormInput" class="form-label Offre">Site</label>
                                          <div class="mb-3">
                                                <input class="form-control" list="datalistOptions" id="ville"
                                                      name="ville" placeholder="Commencez à ecrire...">
                                                <datalist id="datalistOptions">
                                                      <?php
                                                      // foreach ($villes as $ville) {
                                                      //      echo "<option value='{$ville['ville']}'>{$ville['ville']}</option>";
                                                      // }
                                                      ?>
                                                </datalist> 
                              </div>
                  </div> -->

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
                              <button type="submit" class="btn btn-primary" name="insertOffre">Soumettre</button>
                              <a href="listOffre.php" class="btn btn-outline-danger">Annuler</a>

                        </form>
                  </div>
            </div>
      </div>
      <div id="loader" class="loader" style="display: none;"></div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
      </script>

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
            minDate.setDate(minDate.getDate() - 3);
            minDate = minDate.toISOString().split('T')[0];
            document.getElementById('date').setAttribute('min', minDate);

            var maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 2);
            maxDate = maxDate.toISOString().split('T')[0];
            document.getElementById('date').setAttribute('max', maxDate);
      });
      </script>

      <!-- 
            <script>
            $(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("date")[0].setAttribute('min', today);

            var maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 30);
            maxDate = maxDate.toISOString().split('T')[0];
            document.getElementsByName("date")[0].setAttribute('max', maxDate);
            });
            </script> 
      -->

</body>

</html>