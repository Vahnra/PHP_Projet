<?php require_once('config/config.php');


if (isset($_POST['voir'])) {
    $voir = $_POST['voir'];
    header("location: ficheProduit.php?id=$voir");
}

require_once('header/header.php');

var_dump($_SESSION);
?>


<main>
    <!-- Partie haute-->
    <div class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-2">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Shop in style</h1>
                <p class="lead fw-normal text-white-50 mb-0">Bienvenue <?php if (isset($_SESSION["prenom"])) echo "$_SESSION[prenom]" ?> !</p>
            </div>
        </div>
    </div>

    <!-- Partie principale-->

    <div class="row">

        <div class="col-2">

            <div class="col-12 mb-5">


            </div>

            <div class="col-10">

            </div>

            <!-- Pour le filtrage -->

            <?php 

            // query pour avoir les infos de tout pour le filtrage
            $demandeCategorie = $pdo->prepare("SELECT * FROM categorie");
            $demandeCategorie->execute();

            $demandePays = $pdo->prepare("SELECT DISTINCT pays FROM annonce");
            $demandePays->execute();

            $demandeMembre = $pdo->prepare("SELECT * FROM membre");
            $demandeMembre->execute();

            echo "
            <form action='' method='POST' class='col-10 mb-5 ms-auto ms-auto'>
                <label class='col-12 fw-bold mb-1' for='categorie'>Categorie</label>
                <select class=' form-select' name='tri2' id='tri2' onchange='this.form.submit()'>
                <option value='' selected>Toutes les catégories</option>";
                while ($ligne = $demandeCategorie->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='filtreCategorie'>$ligne[titre]</option> ";
                }
                    
            echo "       
                </select>
                <label class='col-12 fw-bold mb-1 mt-4' for='categorie'>Pays</label>
                <select class=' form-select' name='tri2' id='tri2' onchange='this.form.submit()'>
                    <option value='' selected>Tous les pays</option>";
                while ($ligne = $demandePays->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='filtrePays'>$ligne[pays]</option> ";
                }

            echo "
                </select>
                <label class='col-12 fw-bold mb-1 mt-4' for='categorie'>Membre</label>
                <select class=' form-select' name='tri2' id='tri2' onchange='this.form.submit()'>
                    <option value='' selected>Toutes les membres</option>";
                while ($ligne = $demandeMembre->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='filtreMembre'>$ligne[nom]</option> ";
                }

            echo "
                </select>
                <label class='col-12 fw-bold mb-1 mt-4' class='form-label' for='categorie'>Prix maximum</label>
                <input type='range' class='form-range' value='500' min='0' max='10000' step='10' id='customRange3' oninput='this.nextElementSibling.value = this.value'>
                <output></output>
                "
            ?>    
        
            </form>


        </div>

        <section class="py-5 col-10">
            <div class="container px-4 px-lg-5 mt-2">
                <div class="row">
                    <form action="" method="POST" class="col-5 mb-5 ms-auto me-5">
                        <label class="col-12" for=""></label>
                        <select class=" form-select" name="tri" id="tri" onchange="this.form.submit()">
                            <option value="" selected>Trier par...</option>
                            <option value="triMoinsPlus">Trier par prix (du moins cher au plus cher)</option>
                            <option value="triPlusMoins">Trier par prix (du plus cher au moins cher)</option>
                        </select>
                        <!-- <input type="submit" value="submit"> -->
                    </form>
                </div>
                <div class="row gx-2 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">

                    <?php

                    if (isset($_POST['tri'])) {
                        $tri = $_POST['tri'];

                        if ($tri == 'triMoinsPlus') {
                            $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY prix ASC");
                        } elseif ($tri == 'triPlusMoins') {
                            $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY prix DESC");
                        }
                    } else {
                        $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ");
                    }


                    while ($ligne = $reponse->fetch(PDO::FETCH_ASSOC)) {
                        $demande = $pdo->prepare("SELECT photo1, photo2, photo3, photo4, photo5 FROM photo WHERE photo_id = :photo_id");
                        $demande->bindParam(':photo_id', $ligne['photo_id'], PDO::PARAM_STR);
                        $demande->execute();
                        $donnees = $demande->fetch(PDO::FETCH_ASSOC);
                        if (strlen($ligne['description_courte']) > 20) $ligne['description_courte'] = substr($ligne['description_courte'], 0, 100) . '...';
                        echo "
        <div class='col mb-5'>
            <div class='card h-100' style='width: 20rem;'>
                
                <img class='card-img-top' style='max-width: 100%; object-fit:cover; aspect-ratio: 1;' ' src='upload/$donnees[photo1]' alt='...' />
                    <div class='card-body p-4'>
                        <div class='text-center'>
                            <!-- Product name-->
                            <h5 class='fw-bolder'>$ligne[titre]</h5>
                                    <!-- Product price-->
                                    <p class='fw-bolder'>$ligne[prix] €</p>
                        </div>
                        <p class='card-text mt-2'>$ligne[description_courte]</p>
                    </div>
                    <!-- Product actions-->
                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                    <div class='text-center'><form method='POST'><button type='submit' id='voir' name='voir' value='$ligne[id_annonce]' class='btn btn-outline-dark mt-auto'>Voir plus</button></form></div>
                </div>
            </div>
        </div>


        ";
                    }



                    ?>


                </div>
            </div>

        </section>
    </div>
</main>
<?php

require_once('footer/footer.php')

?>