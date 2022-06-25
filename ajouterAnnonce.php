<?php require_once('config/config.php');

require_once('header/header.php');

$titreErr = $descriptionCourteErr = $descriptionLongueErr = $prixErr = $adresseErr = $cpErr = '';

if (isset($_POST['annonce'])) {

    if (isset($_POST['titre']) && isset($_POST['descriptionCourte']) && isset($_POST['descriptionLongue']) && isset($_POST['prix']) && isset($_POST['pays']) && isset($_POST['ville']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['categorie'])) {

        function uploadFichier($fichier)
        {

            $targetDir = "upload/";
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

            $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
            $fileNames = array_filter($fichier['name']);
            if (!empty($fileNames)) {
                var_dump($_FILES);

                foreach ($fichier['name'] as $key => $val) {

                    $fileName = basename($fichier['name'][$key]);

                    $file = uniqid('', true) . $fileName;
                    $targetFilePath = $targetDir . $file;

                    $uploadedfile[] = $file;

                    var_dump($uploadedfile);

                    global $uploadedfile;

                    // Check whether file type is valid 
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


                    if (in_array($fileType, $allowTypes)) {

                        if (move_uploaded_file($fichier["tmp_name"][$key], $targetFilePath)) {
                        } else {
                            $errorUpload .= $fichier['name'][$key] . ' | ';
                        }
                    } else {
                        $errorUploadType .= $fichier['name'][$key] . ' | ';
                    }
                }
            }
        }



        if (isset($_FILES['file1'])) {

            uploadFichier($_FILES['file1']);
            $insertion = $pdo->prepare("INSERT INTO photo (photo1) VALUE (:image1)");
            $insertion->bindParam(':image1', $uploadedfile[0], PDO::PARAM_STR);
            $insertion->execute();
        }

        $photo = $uploadedfile[0];

        if (!empty($uploadedfile[1])) {

            $reponse = $pdo->prepare("SELECT photo_id FROM photo WHERE photo1 = :photo1");
            $reponse->bindParam(':photo1', $photo, PDO::PARAM_STR);
            $reponse->execute();
            $imageI = $reponse->fetch(PDO::FETCH_ASSOC);
            $image1 = $imageI['photo_id'];

            $insertion = $pdo->prepare("UPDATE photo SET photo2 = :image2 where photo_id = $image1");
            $insertion->bindParam(':image2', $uploadedfile[1], PDO::PARAM_STR);
            $insertion->execute();
        }

        $reponse = $pdo->prepare("SELECT photo_id FROM photo WHERE photo1 = :photo1");
        $reponse->bindParam(':photo1', $photo, PDO::PARAM_STR);
        $reponse->execute();
        $imageI = $reponse->fetch(PDO::FETCH_ASSOC);
        $image1 = $imageI['photo_id'];

        if (!empty($uploadedfile[1])) {

            $insertion = $pdo->prepare("UPDATE photo SET photo2 = :image2 where photo_id = $image1");
            $insertion->bindParam(':image2', $uploadedfile[1], PDO::PARAM_STR);
            $insertion->execute();
        }


        if (!empty($uploadedfile[2])) {
            $insertion = $pdo->prepare("UPDATE photo SET photo3 = :image2 where photo_id = $image1");
            $insertion->bindParam(':image2', $uploadedfile[2], PDO::PARAM_STR);
            $insertion->execute();
        }

        if (!empty($uploadedfile[3])) {
            $insertion = $pdo->prepare("UPDATE photo SET photo4 = :image2 where photo_id = $image1");
            $insertion->bindParam(':image2', $uploadedfile[3], PDO::PARAM_STR);
            $insertion->execute();
        }

        if (!empty($uploadedfile[4])) {
            $insertion = $pdo->prepare("UPDATE photo SET photo5 = :image2 where photo_id = $image1");
            $insertion->bindParam(':image2', $uploadedfile[4], PDO::PARAM_STR);
            $insertion->execute();
        }

        $reponse = $pdo->prepare("SELECT photo_id FROM photo WHERE photo1 = :photo1");
        $reponse->bindParam(':photo1', $photo, PDO::PARAM_STR);
        $reponse->execute();
        $imageI = $reponse->fetch(PDO::FETCH_ASSOC);
        var_dump($imageI);
        $imageID = intval($imageI['photo_id']);


        if (empty($_POST['titre'])) {
            $titreErr = "Un titre est necessaire";
        } else {
            $titre = trim($_POST['titre']);
        }

        if (empty($_POST['descriptionCourte'])) {
            $descriptionCourteErr = "Une description courte est necessaire";
        } else {

            $descriptionCourte = trim($_POST['descriptionCourte']);
        }

        if (empty($_POST['descriptionLongue'])) {
            $descriptionLongueErr = "Une description longue est necessaire";
        } else {
            $descriptionLongue = trim($_POST['descriptionLongue']);
        }

        if (empty($_POST['prix'])) {
            $prixErr = "Un prix est necessaire";
        } else {
            $prix = trim($_POST['prix']);
        }


        $pays = trim($_POST['pays']);
        $ville = trim($_POST['ville']);

        if (empty($_POST['adresse'])) {
            $adresseErr = "Une adresse est necessaire";
        } else {
            $adresse = trim($_POST['adresse']);
        }

        if (empty($_POST['cp'])) {
            $cpErr = "Un code postal est necessaire";
        } else {

            $cp = trim($_POST['cp']);
        }


        if (strlen($titre) > 300 || strlen($titre) < 1) {
            $titreErr = "Ce titre est trop court ou trop long";
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

                ";
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
                    <label for="titre">Ttitre de l'annonce</label><span class="error" style="color: #FF0000;"><?php echo " " . $titreErr; ?></span>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre">
                </div>
                <div class="form-group mb-2">
                    <label for="descriptionCourte">Description courte</label><span class="error" style="color: #FF0000;"><?php echo " " . $descriptionCourteErr; ?></span>
                    <input type="text" class="form-control" id="descriptionCourte" name="descriptionCourte" placeholder="Entrez une description courte">
                </div>
                <div class="form-group mb-2">
                    <label for="descriptionLongue">Description longue</label><span class="error" style="color: #FF0000;"><?php echo " " . $descriptionLongueErr; ?></span>
                    <input type="text" class="form-control" class="" id="descriptionLongue" name="descriptionLongue" placeholder="Entrez une discription longue">
                </div>
                <div class="form-group mb-2">
                    <label for="prix">Le prix</label><span class="error" style="color: #FF0000;"><?php echo " " . $prixErr; ?></span>
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
                    <label for="pays">Choisir 5 images max</label>
                    <input type="file" class="col-2 mx-auto" name="file1[]" id="file1" multiple="multiple">
                    <!-- <input type="file" class="col-2 mx-auto" name="file1[]" id="file1">
                    <input type="file" class="col-2 mx-auto" name="file2[]" id="file2">
                    <input type="file" class="col-2 mx-auto" name="file3[]" id="file3">
                    <input type="file" class="col-2 mx-auto" name="file4[]" id="file4">
                    <input type="file" class="col-2 mx-auto" name="file5[]" id="file5"> -->
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
                    <label for="adresse">Votre adresse</label><span class="error" style="color: #FF0000;"><?php echo " " . $adresseErr; ?></span>
                    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Entrez votre adresse">
                </div>
                <div class="form-group mb-2">
                    <label for="cp">Votre code postal</label><span class="error" style="color: #FF0000;"><?php echo " " . $cpErr; ?></span>
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