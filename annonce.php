<?php require_once('config/config.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

if (isset($_POST['delete'])) {
    $deleted = $_POST['delete'];
    $reponse = $pdo->query("DELETE FROM annonce WHERE id_annonce = $deleted");
    echo "
    <script type='text/javascript'>alert('Annonce supprimé');</script>
    ";
}

if (isset($_POST['inspecter'])) {
    $inspecter = $_POST['inspecter'];
    header("location: affichageAnnonce.php?id=$inspecter");
}

if (isset($_POST['modifier'])) {
    $modifier = $_POST['modifier'];
    header("location: modificationAnnonce.php?id=$modifier");
}

require_once('header/header.php');
?>

<main>

    <div class="row">

        <h2 class="text-center mt-4 mb-4">Gestion des annonces</h2>

        <div class="col-1"></div>

        <div class="col-2">

        <form action="" method="POST">
            <label class="col-12" for="">Trier :</label>
            <select class=" form-select" name="tri" id="tri" onchange="this.form.submit()">
                <option value="" selected>Selectionnez..</option>
                <option value="titre">Par titre</option>
                <option value="membre">Par membre</option>
                <option value="categorie">Par catégorie</option>
                <option value="pays">Par pays</option>
                <option value="ville">Par ville</option>
                <option value="date">Par date</option>
            </select>
            <!-- <input type="submit" value="submit"> -->
         </form>  
        </div>

        <div class="col1"></div>

        <div class="col-10 mx-auto mt-5 mb-5 text-center">

        <?php 

            if (isset($_POST['tri'])) {
                $tri = $_POST['tri'];

                if ($tri == 'titre') 
                {
                    $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY titre ASC");
                } 
                elseif ($tri == 'membre') 
                {
                    $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY membre_id ASC");
                }
                elseif ($tri == 'categorie') 
                {
                    $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY categorie_id ASC");
                }
                elseif ($tri == 'pays') 
                {
                    $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY pays ASC");
                }
                elseif ($tri == 'ville') 
                {
                    $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY ville ASC");
                }
                elseif ($tri == 'date') 
                {
                    $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ORDER BY date_enregistrement ASC");
                }

            }
            else 
            {
                $reponse = $pdo->query("SELECT id_annonce, titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement FROM annonce ");
            
            }
            
            
             
                

            
            

            echo '<table border="1" style="border-collapse : collapse; width:100%;">';
            echo '<tr>';
            // Variable pour exclure une valeur
            $exclude = array(11);
            for ($i = 0; $i < $reponse->columnCount(); $i++) 
            {
                $infos_colonne = $reponse->getColumnMeta($i);
                // Condition si valeur 11, elle est exclue
                if (in_array($i, $exclude)) continue;
                echo "<th style='width: 10rem;'>" . ucfirst($infos_colonne['name']) . '</th>';
            }
            echo '<th> Action </th>';
            echo '</tr>';
            while ($ligne = $reponse->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>';
                // foreach ($ligne as $valeur)
                // {
                //     echo "<td>$valeur</td>";
                // }
                echo "<td>$ligne[id_annonce]</td>";
                echo "<td>$ligne[titre]</td>";
                // On racourcie la description
                if(strlen($ligne['description_courte']) > 20) $ligne['description_courte'] = substr($ligne['description_courte'], 0, 20).'...';
                echo "<td>$ligne[description_courte]</td>";
                // On racourcie la description
                if(strlen($ligne['description_longue']) > 20) $ligne['description_longue'] = substr($ligne['description_longue'], 0, 20).'...';
                echo "<td>$ligne[description_longue]</td>";
                echo "<td>$ligne[prix] €</td>";
                // On prend les photos de la table photo
                $demande = $pdo->prepare("SELECT photo1, photo2, photo3, photo4, photo5 FROM photo WHERE photo_id = :photo_id");
                $demande->bindParam(':photo_id', $ligne['photo_id'], PDO::PARAM_STR);
                $demande->execute();
                $donnees = $demande->fetch(PDO::FETCH_ASSOC);
                // Carrousel bootstrap
                echo "<td style='width: 10rem;'><div id='carouselExampleIndicators' class='carousel carousel-dark slide' data-bs-ride='carousel' style='width: 100%; '>
                <div class='carousel-indicators'>
                  <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>
                  <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='1' aria-label='Slide 2'></button>
                  <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='2' aria-label='Slide 3'></button>
                  <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='3' aria-label='Slide 3'></button>
                  <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='4' aria-label='Slide 3'></button>
                </div>
                <div class='carousel-inner'>
                  <div class='carousel-item active' data-bs-interval='500000000'>
                    <img src='upload/$donnees[photo1]' class='d-block w-100' alt='...'>
                  </div>
                  <div class='carousel-item' data-bs-interval='500000000'>
                    <img src='upload/$donnees[photo2]' class='d-block w-100' alt='...'>
                  </div>
                  <div class='carousel-item' data-bs-interval='500000000'>
                    <img src='upload/$donnees[photo3]' class='d-block w-100' alt='...'>
                  </div>
                  <div class='carousel-item' data-bs-interval='500000000'>
                    <img src='upload/$donnees[photo4]' class='d-block w-100' alt='...'>
                  </div>
                  <div class='carousel-item' data-bs-interval='500000000'>
                    <img src='upload/$donnees[photo5]' class='d-block w-100' alt='...'>
                  </div>
           
                </div>
             
              </div></td>";
                // echo "<td><img src='upload/$donnees[photo1]'></td>";
                echo "<td>$ligne[pays]</td>";
                echo "<td>$ligne[ville]</td>";
                echo "<td>$ligne[adresse]</td>";
                echo "<td>$ligne[cp]</td>";
                // On va chercher le prenom qui correspond au id_membre
                $demande = $pdo->prepare("SELECT prenom FROM membre WHERE id_membre = :id_membre");
                $demande->bindParam(':id_membre', $ligne['membre_id'], PDO::PARAM_STR);
                $demande->execute();
                $donees = $demande->fetch(PDO::FETCH_ASSOC);
                echo "<td>$donees[prenom]</td>";
                // On va chercher le titre de la catégorie qui corespond a la categorie_id
                $demande = $pdo->prepare("SELECT titre FROM categorie WHERE id_categorie = :categorie_id");
                $demande->bindParam(':categorie_id', $ligne['categorie_id'], PDO::PARAM_STR);
                $demande->execute();
                $donees = $demande->fetch(PDO::FETCH_ASSOC);
                echo "<td>$donees[titre]</td>";
                echo "<td>$ligne[date_enregistrement]</td>";

                echo "
                <td>

                <form method='post'>

                <button type='submit' class='btn btn-labeled btn-default' id='inspecter' name='inspecter' value='$ligne[id_annonce]' >
                <span class='btn-label'><i class='fa fa-search' ></i></span></button>

                <button type='submit' class='btn btn-labeled btn-default' id='modifier' name='modifier' value='$ligne[id_annonce]'>
                <span class='btn-label'><i class='fas fa-edit'></i></span></button>

                <button type='submit' class='btn btn-labeled btn-default' id='delete' name='delete' value='$ligne[id_annonce]' >
                <span class='btn-label'><i class='fa fa-trash'></i></span></button>


                </form>
                </td>";
                echo '</tr>';
            }
            
            echo '</table>';

        ?>

    </div>


<div class="col1"></div>

</div>

</main>

<?php

require_once('footer/footer.php')


?>