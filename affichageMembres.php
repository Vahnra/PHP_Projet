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

        <h2 class="text-center mb-5">Information du membre numéro <?php echo "$_GET[id]" ?></h2>

        <?php

        $id = $_GET['id'];

        $reponse = $pdo->query("SELECT * FROM membre where id_membre = $id");
        $utilisateur = $reponse->fetch(PDO::FETCH_ASSOC);

        echo '<div class="row">';
        echo '<div class="col-3"></div>';
        echo '<div class="col-6">';
        echo 'Nom : ' . $utilisateur['nom'] . '<hr>';
        echo 'Prenom : ' . $utilisateur['prenom'] . '<hr>';
        echo 'Telephone : ' . $utilisateur['telephone'] . '<hr>';
        echo 'Mail : ' . $utilisateur['email'] . '<hr>';
        echo 'Sexe : ' . $utilisateur['civilite'] . '<hr>';
        echo 'Date de création du compte : ' . $utilisateur['date_enregistrement'] . '<hr>';
        echo '</div></div><hr>';

        ?>



    </div>
    
</main>



<?php

require_once('footer/footer.php')


?>