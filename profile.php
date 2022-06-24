<?php require_once('config/config.php');

require_once('header/header.php');

?>

<main>

    <div class="row mt-5">

        <h2 class="text-center mb-5">Vos informations</h2>

        <?php

        $user = $_SESSION['user'];

        $reponse = $pdo->query("SELECT * FROM membre where id_membre = $user");
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

    <div class="row">

        <div class="col-3"></div>
        <div class="col-6"></div>
        <div class="col-3"></div>

    </div>

</main>


<?php

require_once('footer/footer.php')


?>


