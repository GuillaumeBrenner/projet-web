<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

?>
<!DOCTYPE HTML>
<html>

<head>
      <meta charset="utf-8" />
      <title>Evaluer</title>
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossorigin="anonymous" />
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
      </script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
      </script>
      <style>
      .img-fluid {
            max-width: 40%;
            height: auto;
      }
      </style>
</head>

<body>
      <div class="container mt-5">
            <div class="container">
                  <div class="container-fluid">
                        <?php
                        if (isset($_GET['id'])) {
                              $sql = 'SELECT entreprise.id_entreprise, entreprise.nom, entreprise.logo, entreprise.nombre_etudiant,
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
                                    <h1>Vous allez évaluer
                                          l'entreprise : <?php echo htmlspecialchars($entreprise['nom']); ?>
                                    </h1>
                              </div>
                              <div class="card-body">
                                    <div class="card-header">
                                          <img src="<?php echo $entreprise['logo'] ?>" class="img-thumbnail img-fluid"
                                                alt="Logo <?php echo $entreprise['nom'] ?>" />
                                    </div>
                                    <div class="mb-3 row">
                                          <label class="col-sm-2 col-form-label">Nom</label>
                                          <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                      value="<?= $entreprise['nom'] ?>" disabled>
                                          </div>
                                    </div>
                                    <div class="mb-3 row">
                                          <label class="col-sm-2 col-form-label">Etudiants CESI</label>
                                          <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                      value="<?= $entreprise['nombre_etudiant'] ?>" disabled>
                                          </div>

                                    </div>
                                    <div class="mb-3 row">
                                          <label class="col-sm-2 col-form-label">Région</label>
                                          <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                      value="<?= $entreprise['région'] ?>" disabled>
                                          </div>
                                    </div>
                                    <div class="mb-3 row">
                                          <label class="col-sm-2 col-form-label">Ville</label>
                                          <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                      value="<?= $entreprise['ville'] ?>" disabled>
                                          </div>
                                    </div>
                                    <div class="mb-3 row">
                                          <label class="col-sm-2 col-form-label">Secteur d'activité</label>
                                          <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                      value="<?= $entreprise['secteur'] ?>" disabled>
                                          </div>
                                    </div>
                                    <div class="card-footer text-muted  mt-5">
                                          <div class="row">
                                                <div class="col-sm-4 text-center">
                                                      <h1 class="text-warning mt-4 mb-4">
                                                            <b><span id="average_rating">0.0</span> / 5</b>
                                                      </h1>
                                                      <div class="mb-3">
                                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                                      </div>
                                                </div>

                                                <div class="col-sm-4 text-center">
                                                      <button type="button" name="add_review" id="add_review"
                                                            class="btn btn-primary mb-3">Evaluer ici</button>
                                                      <a href="listEntreprise.php" class="btn btn-primary">Retourner à
                                                            la liste des entreprises</a>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>

                        <?php }
                              
                         // Free result set
                        unset($result);
                        ?>
                  </div>
            </div>
      </div>
</body>

</html>

<div class="modal fade" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
            <div class="modal-content">
                  <div class="modal-header">
                        <h3>Quelle note donnez-vous ?</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                        <h4 class="text-center mt-2 mb-4">
                              <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                              <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                              <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                              <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                              <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                        </h4>
                        <label for="note">Commentaire</label>
                        <div class="form-group">
                              <textarea name="user_review" id="user_review" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                              <input type="hidden" name="id_entreprise" id="id_entreprise" class="form-control"
                                    value="<?= $_GET['id'] ?>" />
                        </div>

                        <div class="form-group text-center mt-4">
                              <button type="button" class="btn btn-primary" id="save_review">Soumettre</button>
                        </div>
                  </div>
            </div>
      </div>
</div>

<script>
var rating_data = 0;

$('#add_review').click(function() {
      $('#review_modal').modal('show');
});

$(document).on('mouseenter', '.submit_star', function() {
      var rating = $(this).data('rating');
      reset_background();
      for (var count = 1; count <= rating; count++) {
            $('#submit_star_' + count).addClass('text-warning');
      }
});

function reset_background() {
      for (var count = 1; count <= 5; count++) {
            $('#submit_star_' + count).addClass('star-light');
            $('#submit_star_' + count).removeClass('text-warning');
      }
}

$(document).on('mouseleave', '.submit_star', function() {
      reset_background();
      for (var count = 1; count <= rating_data; count++) {
            $('#submit_star_' + count).removeClass('star-light');
            $('#submit_star_' + count).addClass('text-warning');
      }
});

$(document).on('click', '.submit_star', function() {
      rating_data = $(this).data('rating');
});

$('#save_review').click(function() {
      var id_entreprise = $('#id_entreprise').val();
      var user_review = $('#user_review').val();
      if (user_review == '') {
            alert("Remplir les deux champs");
            return false;
      } else {
            $.ajax({
                  type: "POST",
                  url: "submit_rating.php",
                  data: {
                        rating_data: rating_data,
                        user_review: user_review,
                        id_entreprise: id_entreprise
                  },
                  success: function(data) {
                        $('#review_modal').modal('hide');
                        alert(data);
                        setTimeout(function() {
                              window.location = 'listEntreprise.php'
                        }, 2000);
                  }
            })
      }
});
</script>