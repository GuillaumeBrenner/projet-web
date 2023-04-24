<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

if (isset($_GET['id'])) {
      $sql = "SELECT *
      FROM offre
      Where id_offre = " . $_GET['id'];
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>

      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Postuler</title>
      <link rel="stylesheet" href="../../assets/vendors/fontawesome/css/all.min.css">
      <link rel="stylesheet" href="../../assets/vendors/bootstrap/css/bootstrap.min.css">
</head>

<body>
      <?php

      if ($result = $pdo->query($sql)) {
            if ($result->rowCount() > 0) {
                  while ($row = $result->fetch()) {
      ?>
      <div class="container mt-5">
            <div class="card">
                  <h1 class="Offre card-header">Postuler à l'offre "<?php echo htmlspecialchars($row['Titre']); ?>"</h1>
                  <div class="card-body">
                        <form action="postuler.php" method="post" enctype="multipart/form-data">
                              <div class="row">
                                    <input type="hidden" name="id_offre" id="id_offre" value="<?= $_GET['id'] ?>">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Nom</label>
                                                      <input type="Text" class="form-control" id="nom" name="nom"
                                                            required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Prénom</label>
                                                      <input type="Text" class="form-control" id="prenom" name="prenom"
                                                            required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Email</label>
                                                      <input type="email" class="form-control" id="mail" name="mail"
                                                            required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label class="form-label Offre">Téléphone</label>
                                                      <input type="tel" class="form-control" id="telephone"
                                                            name="telephone" required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="file" class="form-label">CV</label>
                                                      <input type="file" id="cv" name="cv" class="form-control"
                                                            required>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="file" class="form-label">Lettre de motivation</label>
                                                      <input type="file" id="ldm" name="ldm" class="form-control"
                                                            required>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                              <button type="submit" class="btn btn-primary">Soumettre</button>
                              <a href="listOffre.php" class="btn btn-outline-danger">Annuler</a>
                        </form>
                  </div>

            </div>
      </div>
      <?php }
            } else {
                  echo 'Erreur de données, Veuillez le signaler à votre référent';
                  echo '<div class="card-footer text-muted"><a href="listEntreprise.php" class="btn btn-info">
                                          <i class=" fa fa-arrow-left">
                                          </i>Retourner</a></div>';
            }
      } // Free result set
      unset($result);
      ?>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
      </script>

</body>

</html>