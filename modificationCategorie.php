<?php require_once('config/config.php');

require_once('header/header.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

$id = $_GET['id'];

if (!empty($_POST['titre'])) {
    $titre = trim($_POST['titre']);
    $inscription = $pdo->prepare("UPDATE categorie SET titre = :titre WHERE id_categorie = $id");
    $inscription->bindParam(':titre', $titre, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
        <script>window.location = 'categorie.php'</script>
    ";
}

if (!empty($_POST['descrip'])) {
    $descrip = trim($_POST['descrip']);
    $inscription = $pdo->prepare("UPDATE categorie SET motscles = :description WHERE id_categorie = $id");
    $inscription->bindParam(':description', $descrip, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
        <script>window.location = 'categorie.php'</script>
    ";
}

?>

<main>


    <div class="row">

        <h2 class="text-center mt-4 mb-4">Modification de la catégorie <?php echo "$_GET[id]" ?></h2>

            <div class="col-2"></div>

            <div class="col-8">

                <form method="post" class="row">

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de la salle">
                    </div>

                    <div class="mb-3">
                        <label for="descrip" class="form-label">Description courte</label>
                        <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Description de votre annonce">
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