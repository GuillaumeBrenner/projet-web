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
</head>

<body>
      <div class="container mt-5">
            <div class="card">
                  <h1 class="Offre card-header">POSTULER</h1>
                  <div class="card-body">
                        <form action="insertion.php" method="post">
                              <div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput" class="form-label Offre">Titre</label>
                                                      <input type="Text" class="form-control"
                                                            value="<?php $_SESSION['id'] ?>" name="id_c" placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput Description"
                                                            class="form-label Offre">Description</label>
                                                      <input type="Text" class="form-control Description"
                                                            id="exampleFormControlInput1" name="description"
                                                            placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput Description"
                                                            class="form-label Offre">Description</label>
                                                      <input type="Text" class="form-control Description"
                                                            id="exampleFormControlInput1" name="description"
                                                            placeholder="">
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="mb-3">
                                                      <label for="FormInput Description"
                                                            class="form-label Offre">Description</label>
                                                      <input type="Text" class="form-control Description"
                                                            id="exampleFormControlInput1" name="description"
                                                            placeholder="">
                                                </div>
                                          </div>
                                    </div>

                              </div>
                              <button type="submit" name="insertOffre" class="btn btn-primary">Soumettre</button>
                              <a href="listOffre.php" class="btn btn-outline-danger">Annuler</a>

                        </form>
                  </div>

            </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
      </script>

</body>

</html>