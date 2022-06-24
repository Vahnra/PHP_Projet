<?php require_once('config/config.php');

require_once('header/header.php');


if (isset($_POST['annonce'])) {

    if (isset($_POST['titre']) && isset($_POST['descriptionCourte']) && isset($_POST['descriptionLongue']) && isset($_POST['prix']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['categorie'])) {

        if ($_POST['titre'] == "" || $_POST['descriptionCourte'] == "" || $_POST['descriptionLongue'] == "" || $_POST['prix'] == "" || $_POST['pays'] == "" || $_POST['ville'] == "" || $_POST['adresse'] == "" || $_POST['cp'] == "" || $_POST['categorie'] == "") {

            echo "<script>alert('Entrez tout les infos')</script>";
        } else {

            // Fonction pour l'upload d'image
            function uploadImage($fichier)
            {
                $tmpName = $fichier['tmp_name'];
                $name = $fichier['name'];
                $size = $fichier['size'];
                $error = $fichier['error'];

                // On décompose le nom du fichier pour avoir son extension
                $tabExtension = explode('.', $name[0]);
                // On met l'extension tout en minuscule pour éviter les erreuirs de saisit
                $extension = strtolower($tabExtension[1]);


                // On fais un array pour les noms d'extensions autorisé
                $extensions = ['jpg', 'png', 'jpeg'];
                // On détermine la taille max du fichier en octets
                $maxSize = 400000;
                // Condition extension/taille/error
                if (in_array($extension, $extensions) && $error[0] == 0) {

                    $uniqueName = uniqid('', true);


                    $file = $uniqueName . "." . $extension;

                    move_uploaded_file($tmpName[0], './upload/' . $file);

                    // On return la valeur de $file
                    return $file;
                } else {
                    echo "Mauvaise extension ou taille trop grande";
                }
            }

            // image 1

            if (isset($_FILES['file1'])) {

                $file1 = uploadImage($_FILES['file1']);
            }

            // image 2

            if (isset($_FILES['file2'])) {

                $file2 = uploadImage($_FILES['file2']);
            }

            // image 3
            if (isset($_FILES['file3'])) {

                $file3 = uploadImage($_FILES['file3']);
            }

            // image 4
            if (isset($_FILES['file4'])) {

                $file4 = uploadImage($_FILES['file4']);
            }

            // image 5
            if (isset($_FILES['file5'])) {

                $file5 = uploadImage($_FILES['file5']);
            }

            $insertion = $pdo->prepare("INSERT INTO photo (photo1, photo2, photo3, photo4, photo5) VALUE (:image1, :image2, :image3, :image4, :image5)");
            $insertion->bindParam(':image1', $file1, PDO::PARAM_STR);
            $insertion->bindParam(':image2', $file2, PDO::PARAM_STR);
            $insertion->bindParam(':image3', $file3, PDO::PARAM_STR);
            $insertion->bindParam(':image4', $file4, PDO::PARAM_STR);
            $insertion->bindParam(':image5', $file5, PDO::PARAM_STR);
            $insertion->execute();



            $photo = $file1 . ", " . $file2 . ", " . $file3 . ", " . $file4 . ", " . $file5;



            $reponse = $pdo->prepare("SELECT photo_id FROM photo WHERE photo1 = :photo1");
            $reponse->bindParam(':photo1', $file1, PDO::PARAM_STR);
            $reponse->execute();
            $imageI = $reponse->fetch(PDO::FETCH_ASSOC);
            $imageID = intval($imageI['photo_id']);

            $titre = trim($_POST['titre']);
            if (strlen($titre) > 100 || strlen($titre) < 5) {
                echo "<script type='text/javascript'>alert('Ce titre est trop long ou trop court');</script>";
            } else {

                $descriptionCourte = trim($_POST['descriptionCourte']);
                $descriptionLongue = trim($_POST['descriptionLongue']);
                $prix = trim($_POST['prix']);
                $pays = trim($_POST['pays']);
                $ville = trim($_POST['ville']);
                $adresse = trim($_POST['adresse']);
                $cp = trim($_POST['cp']);
                if (!is_numeric($cp)) {
                    echo "<script type='text/javascript'>alert('Ce code postal est invalide');</script>";
                } else {


                    $categorie = trim($_POST['categorie']);
                    $membre_id = trim($_SESSION['user']);

                    $inscription = $pdo->prepare("INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement) VALUES (:titre, :descriptionCourte, :descriptionLongue, :prix, :photo, :pays, :ville, :adresse, :cp, :membre_id, :photo_id, :categorie, NOW())");
                    $inscription->bindParam(':titre', $titre, PDO::PARAM_STR);
                    $inscription->bindParam(':descriptionCourte', $descriptionCourte, PDO::PARAM_STR);
                    $inscription->bindParam(':descriptionLongue', $descriptionLongue, PDO::PARAM_STR);
                    $inscription->bindParam(':prix', $prix, PDO::PARAM_STR);
                    $inscription->bindParam(':photo', $photo, PDO::PARAM_STR);
                    $inscription->bindParam(':pays', $pays, PDO::PARAM_STR);
                    $inscription->bindParam(':ville', $ville, PDO::PARAM_STR);
                    $inscription->bindParam(':adresse', $adresse, PDO::PARAM_STR);
                    $inscription->bindParam(':cp', $cp, PDO::PARAM_STR);
                    $inscription->bindParam(':membre_id', $membre_id, PDO::PARAM_STR);
                    $inscription->bindParam(':photo_id', $imageID, PDO::PARAM_STR);
                    $inscription->bindParam(':categorie', $categorie, PDO::PARAM_STR);
                    $inscription->execute();

                    echo "
        <script type='text/javascript'>alert('Annonce bien posté !');</script>
        <script>window.location = 'ajouterAnnonce.php'</script>
        ";
                }
            }
        }
    }
}




?>

<main>

    <div class="row">

        <h2 class="text-center mt-3 mb-5">Poster une nouvelle annonce</h2>

        <form method="post" class="row" enctype="multipart/form-data">

            <div class="col-1"></div>

            <div class="col-5">
                <div class="form-group mb-2">
                    <label for="titre">Ttitre de l'annonce</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre">
                </div>
                <div class="form-group mb-2">
                    <label for="descriptionCourte">Description courte</label>
                    <input type="text" class="form-control" id="descriptionCourte" name="descriptionCourte" placeholder="Entrez une description courte">
                </div>
                <div class="form-group mb-2">
                    <label for="descriptionLongue">Description longue</label>
                    <input type="text" class="form-control" class="" id="descriptionLongue" name="descriptionLongue" placeholder="Entrez une discription longue">
                </div>
                <div class="form-group mb-2">
                    <label for="prix">Le prix</label>
                    <input type="text" class="form-control" id="prix" name="prix" placeholder="Entrez le prix">
                </div>

                <div class="form-group">
                    <label for="categorie">Choisir la catégorie</label>
                    <select class="form-select" id="categorie" name="categorie">
                        <option selected>Choisisez la catégorie</option>
                        <?php
                        $reponse = $pdo->query("SELECT id_categorie, titre FROM categorie");
                        $ligne = $reponse->fetchAll(PDO::FETCH_ASSOC);
                        // var_dump($ligne);
                        foreach ($ligne as $soustableau) {
                            echo "<option value='$soustableau[id_categorie]'>$soustableau[titre]</option> ";
                        }
                        ?>


                    </select>
                </div>

            </div>

            <div class="col-5">
                <div class="form-group row">
                    <label for="pays">Choisir 5 images</label>
                    <input type="file" class="col-2 mx-auto" name="file1[]" id="file1">
                    <input type="file" class="col-2 mx-auto" name="file2[]" id="file2">
                    <input type="file" class="col-2 mx-auto" name="file3[]" id="file3">
                    <input type="file" class="col-2 mx-auto" name="file4[]" id="file4">
                    <input type="file" class="col-2 mx-auto" name="file5[]" id="file5">
                    <!-- <button type="submit" class="form-control" id="image" name="image">Upload</button> -->
                </div>
                <div class="form-group mb-2 mt-3">
                    <label for="pays">Votre pays</label>
                    <!-- <input type="text" class="form-control" id="pays" name="pays" placeholder="Entrez votre pays"> -->
                    <select class="form-select" id="pays" name="pays">
                        <option selected>Choisissez votre pays</option>
                        <?php $countries = array(
                            'fr' => 'France',
                            'us' => 'USA',
                            'de' => 'Germany',
                            'pl' => 'Poland',
                        );

                        foreach ($countries as $code => $name) {
                            echo '<option value="' . $name . '" ' . ($country == $code ? 'selected="selected"' : null) . '>' . $name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="ville">Votre ville</label>
                    <!-- <input type="text" class="form-control" id="ville" name="ville" placeholder="Entrez votre ville"> -->
                    <select class="form-select" id="ville" name="ville">
                        <option selected>Choisissez votre ville</option>
                        <?php $towns = array(
                            '1' => 'Paris',
                            '2' => 'Strasbourg',
                            '3' => 'Marseille',
                            '4' => 'Lyon',
                        );

                        foreach ($towns as $code => $name) {
                            echo '<option value="' . $name . '" ' . ($town == $code ? 'selected="selected"' : null) . '>' . $name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="adresse">Votre adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Entrez votre adresse">
                </div>
                <div class="form-group mb-2">
                    <label for="cp">Votre code postal</label>
                    <input type="text" class="form-control" id="cp" name="cp" placeholder="Entrez votre code postal">
                </div>

            </div>

            <div class="col-1"></div>

            <div class="col-12 text-center mt-3">
                <button type="submit" class="btn btn-primary mt-2" id="annonce" name="annonce">Submit</button>
            </div>

        </form>

    </div>



    </div>
</main>

<?php

require_once('footer/footer.php')


?>