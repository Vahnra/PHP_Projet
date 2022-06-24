<?php require_once('config/config.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

if (isset($_POST['titre']) && isset($_POST['descrip'])) {
    $titre = trim($_POST['titre']);
    $descrip = trim($_POST['descrip']);

    $reponse = $pdo->prepare("INSERT INTO categorie (titre, motscles) VALUES (:titre, :descrip)");
    $reponse->bindparam(':titre', $titre, PDO::PARAM_STR);
    $reponse->bindparam(':descrip', $descrip, PDO::PARAM_STR);
    $reponse->execute();

    echo "<script type='text/javascript'>alert('Catégorie ajouté avec succes');</script>
        <script>window.location = 'categorie.php'</script>
    ";
}


if (isset($_POST['delete'])) {
    $deleted = $_POST['delete'];
    $reponse = $pdo->query("DELETE FROM categorie WHERE id_categorie = $deleted");
    echo "
    <script type='text/javascript'>alert('Catégorie supprimé');</script>
    <script>window.location = 'categorie.php'</script>
    ";
}

if (isset($_POST['inspecter'])) {
    $inspecter = $_POST['inspecter'];
    header("location: affichageCategorie.php?id=$inspecter");
}

if (isset($_POST['modifier'])) {
    $modifier = $_POST['modifier'];
    header("location: modificationCategorie.php?id=$modifier");
}

require_once('header/header.php');

?>

<main>


<div class="row">

    <h2 class="text-center mt-4 mb-4">Gestions des catégories</h2>

    <div class="col-1"></div>

    <div class="col-10 mx-auto mt-5 mb-5 text-center">

        <?php 

            $reponse = $pdo->query("SELECT * FROM categorie");

            echo '<table border="1" style="border-collapse : collapse; width:100%;">';
            echo '<tr>';
            for ($i = 0; $i < $reponse->columnCount(); $i++) 
            {
                $infos_colonne = $reponse->getColumnMeta($i);
                
                echo '<th>' . ucfirst($infos_colonne['name']) . '</th>';
            }
            echo '<th> Action </th>';
            echo '</tr>';
            while ($ligne = $reponse->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>';
                foreach ($ligne as $valeur)
                {
                    echo "<td>$valeur</td>";
                }
                echo "
                <td>

                <form method='post'>

                <button type='submit' class='btn btn-labeled btn-default' id='inspecter' name='inspecter' value='$ligne[id_categorie]' >
                <span class='btn-label'><i class='fa fa-search' ></i></span></button>

                <button type='submit' class='btn btn-labeled btn-default' id='modifier' name='modifier' value='$ligne[id_categorie]'>
                <span class='btn-label'><i class='fa fa-chevron-left'></i></span></button>

                <button type='submit' class='btn btn-labeled btn-default' id='delete' name='delete' value='$ligne[id_categorie]' >
                <span class='btn-label'><i class='fa fa-trash'></i></span></button>


                </form>
                </td>";
                echo '</tr>';
            }
            
            echo '</table>';

        ?>

    </div>

    <div class="col-1"></div>


</div>


<div class="row">

        <h3 class="text-center mb-5">Ajouter une catégorie</h3>

        <div class="col-2"></div>

        <div class="col-8">

            <form method="post" class="row">

                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de la catégorie">
                </div>

                <div class="mb-3">
                    <label for="descrip" class="form-label">Mots clés</label>
                    <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Mots clés">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary col-1">Submit</button>
                </div>

            </form>

        </div>

        <div class="col-2"></div>

</div>


</main>



<?php

require_once('footer/footer.php')


?>