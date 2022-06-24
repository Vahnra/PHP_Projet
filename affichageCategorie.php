<?php require_once('config/config.php');

require_once('header/header.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

$id = $_GET['id'];

?>

<main>

    <div class="row mt-5">

        <h2 class="text-center mb-5">Information sur la catégorie <?php echo "$_GET[id]" ?></h2>

        <?php

        $id = $_GET['id'];

        $reponse = $pdo->query("SELECT * FROM categorie where id_categorie = $id");
        $categorie = $reponse->fetch(PDO::FETCH_ASSOC);

        echo '<div class="row">';
        echo '<div class="col-3"></div>';
        echo '<div class="col-6">';
        echo 'Titre : ' . $categorie['titre'] . '<hr>';
        echo 'Mots clés de la catégorie : ' . $categorie['motscles'] . '<hr>';
        echo '</div></div><hr>';

        ?>



    </div>
    
</main>



<?php

require_once('footer/footer.php')


?>