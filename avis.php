<?php require_once('config/config.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}



if (isset($_POST['delete'])) {
    $deleted = $_POST['delete'];
    $reponse = $pdo->query("DELETE FROM note WHERE id_note = $deleted");
    echo "
    <script type='text/javascript'>alert('Avis supprimé');</script>
    <script>window.location = 'avis.php'</script>
    ";
}

if (isset($_POST['inspecter'])) {
    $inspecter = $_POST['inspecter'];
    header("location: affichageAvis.php?id=$inspecter");
}

if (isset($_POST['modifier'])) {
    $modifier = $_POST['modifier'];
    header("location: modificationAvis.php?id=$modifier");
}

require_once('header/header.php');

?>

<main>

    <div class="row">

        <h2 class="text-center mt-4 mb-4">Gestion des avis</h2>

        <div class="col1"></div>

        <div class="col-10 mx-auto mt-5 mb-5 text-center">

        <?php 

            $reponse = $pdo->query("SELECT * FROM note");

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

                <button type='submit' class='btn btn-labeled btn-default' id='inspecter' name='inspecter' value='$ligne[id_note]' >
                <span class='btn-label'><i class='fa fa-search' ></i></span></button>

                <button type='submit' class='btn btn-labeled btn-default' id='modifier' name='modifier' value='$ligne[id_note]'>
                <span class='btn-label'><i class='fa fa-chevron-left'></i></span></button>

                <button type='submit' class='btn btn-labeled btn-default' id='delete' name='delete' value='$ligne[id_note]' >
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