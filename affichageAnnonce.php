<?php require_once('config/config.php');

require_once('header/header.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit;
}

// Onrécupère l'$id de l'annonce depuis la page précédente
$id = $_GET['id'];

?>


<main>

    <div class="row mt-5">

        <h2 class="text-center mb-5">Information de l'annonce numéro <?php echo "$_GET[id]" ?></h2>

        <?php

        $id = $_GET['id'];

        $reponse = $pdo->query("SELECT * FROM annonce where id_annonce = $id");
        $annonce = $reponse->fetch(PDO::FETCH_ASSOC);

        echo '<div class="row">';
        echo '<div class="col-3"></div>';
        echo '<div class="col-6">';
        echo 'Titre de l\'annonce : ' . $annonce['titre'] . '<hr>';
        echo 'Description courte : ' . $annonce['description_courte'] . '<hr>';
        echo 'Description longue : ' . $annonce['description_longue'] . '<hr>';
        echo 'Prix : ' . $annonce['prix'] . ' €<hr>';
        echo 'Pays : ' . $annonce['pays'] . '<hr>';
        echo 'Ville : ' . $annonce['ville'] . '<hr>';
        echo 'L\'adresse : ' . $annonce['ville'] . '<hr>';
        echo 'Le code postal : ' . $annonce['cp'] . '<hr>';

        // On prend le titre de la catégorie depuis la table catégorie à partir du id_categorie
        $demande = $pdo->prepare("SELECT titre FROM categorie WHERE id_categorie = :categorie_id");
        $demande->bindParam(':categorie_id', $annonce['categorie_id'], PDO::PARAM_STR);
        $demande->execute();
        $donees = $demande->fetch(PDO::FETCH_ASSOC);
        echo 'Le catégorie de l\'annonce : ' . $donees['titre'] . '<hr>';
        echo 'La date d\'enregistrement de l\'annonce : ' . $annonce['date_enregistrement'] . '<hr>';
        echo '</div></div>';

        // On récupère les photos depuis la table photo a partir du photo_id
        $demande = $pdo->prepare("SELECT photo1, photo2, photo3, photo4, photo5 FROM photo WHERE photo_id = :photo_id");
        $demande->bindParam(':photo_id', $annonce['photo_id'], PDO::PARAM_STR);
        $demande->execute();
        $donnees = $demande->fetch(PDO::FETCH_ASSOC);
        echo '<div class="row">';
        echo "<div class='col-3'></div>";
        echo "<div id='carouselExampleIndicators' class='carousel carousel-dark slide col-6' data-bs-ride='carousel'>
        <div class='carousel-indicators'>
          <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>
          <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='1' aria-label='Slide 2'></button>
          <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='2' aria-label='Slide 3'></button>
          <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='3' aria-label='Slide 3'></button>
          <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='4' aria-label='Slide 3'></button>
        </div>
        <div class='carousel-inner' style='max-width:50rem; max-height:50rem !important;'>
          <div class='carousel-item active' data-bs-interval='500000000'>
            <img src='upload/$donnees[photo1]' class='d-block w-100' style='max-width:100%; object-fit:cover; aspect-ratio: 1; alt='...'>
          </div>
          <div class='carousel-item' data-bs-interval='500000000'>
            <img src='upload/$donnees[photo2]' class='d-block w-100' style='max-width:100%; object-fit:cover; aspect-ratio: 1; alt='...'>
          </div>
          <div class='carousel-item' data-bs-interval='500000000'>
            <img src='upload/$donnees[photo3]' class='d-block w-100' style='max-width:100%; object-fit:cover; aspect-ratio: 1; alt='...'>
          </div>
          <div class='carousel-item' data-bs-interval='500000000'>
            <img src='upload/$donnees[photo4]' class='d-block w-100' style='max-width:100%; object-fit:cover; aspect-ratio: 1; alt='...'>
          </div>
          <div class='carousel-item' data-bs-interval='500000000'>
            <img src='upload/$donnees[photo5]' class='d-block w-100' style='max-width:100%; object-fit:cover; aspect-ratio: 1; alt='...'>
          </div>
          <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='prev'>
          <span class='carousel-control-prev-icon' aria-hidden='true'></span>
          <span class='visually-hidden'>Previous</span>
        </button>
        <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='next'>
          <span class='carousel-control-next-icon' aria-hidden='true'></span>
          <span class='visually-hidden'>Next</span>
        </button>
   
        </div>
     
      </div>";


        ?>



    </div>

</main>

<?php

require_once('footer/footer.php')


?>

