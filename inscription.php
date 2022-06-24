<?php require_once('config/config.php');

// error_reporting(0);

$pseudoErr = $nomErr = $prenomErr = $prenomErr = $telephoneErr = $sexeErr = $mailErr = $mdpErr = '';
$pseudo = $nom = $prenom = $prenom = $telephone = $sexe = $mail = $mdp = '';

if (isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['sexe']) && isset($_POST['mail'])  && isset($_POST['motDePasse'])) {

    if ($_POST['pseudo'] == "" || $_POST['nom'] == "" || $_POST['prenom'] == "" || $_POST['telephone'] == "" || $_POST['sexe'] == "" || $_POST['mail'] == "" || $_POST['motDePasse'] == "") {
        // echo "
        // <script>alert('Entrez tout les infos')</script>
        if (empty($_POST["pseudo"])) {
            $pseudoErr = "Un pseudo est necessaire";
        }else{
            $pseudo = trim($_POST['pseudo']);
        }

        if (empty($_POST["nom"])) {
            $nomErr = "Un nom est necessaire";
        }else{
            $nom = trim($_POST['nom']);
        }

        if (empty($_POST["prenom"])) {
            $prenomErr = "Un prénom est necessaire";
        }else{
            $prenom = trim($_POST['prenom']);
        }

        if (empty($_POST["telephone"])) {
            $telephoneErr = "Un numéro de télephone est necessaire";
        }

        if ($_POST["sexe"] == 'Choisisez votre sexe') {
            $sexeErr = "Choisissez votre sexe";
        }

        if (empty($_POST["mail"])) {
            $mailErr = "Un mail est necessaire";
        }

        if (empty($_POST["mdp"])) {
            $mdpErr = "Un mdp est necessaire";
        }


    
    } else {
        $pseudo = trim($_POST['pseudo']);

        if (strlen($pseudo) < 3 || strlen($pseudo) >= 15) {
            $pseudoErr = "Ce pseudo est trop court ou trop long";
        } else {
            
            $stmt = $pdo->prepare("SELECT * FROM membre WHERE pseudo=?");
            $stmt->execute([$pseudo]);
            $user = $stmt->fetch();

            if ($user) {
                $pseudoErr = "Ce pseudo est déjà utilisé";
            } else {
                $nom = trim($_POST['nom']);
                $prenom = trim($_POST['prenom']);
                $telephone = trim($_POST['telephone']);

                if (!is_numeric($telephone)) {

                    $telephoneErr = "Ce numéro de téléphone n'est pas valide";

                } else {
               
                    $sexe = trim($_POST['sexe']);
                    $mail = trim($_POST['mail']);
                    $stmtd = $pdo->prepare("SELECT * FROM membre WHERE email=?");
                    $stmtd->execute([$mail]);
                    $user = $stmtd->fetch();

                    if ($user) {
                        $mailErr = "Ce mail est déjà utilisé";
                    } else {
                        $mdp = trim($_POST['motDePasse']);
                        $hashed_mdp = password_hash($mdp, PASSWORD_BCRYPT);

                        $inscription = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :mail, :sexe, NOW())");
                        $inscription->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
                        $inscription->bindParam(':mdp', $hashed_mdp, PDO::PARAM_STR);
                        $inscription->bindParam(':nom', $nom, PDO::PARAM_STR);
                        $inscription->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                        $inscription->bindParam(':telephone', $telephone, PDO::PARAM_STR);
                        $inscription->bindParam(':mail', $mail, PDO::PARAM_STR);
                        $inscription->bindParam(':sexe', $sexe, PDO::PARAM_STR);
                        $inscription->execute();

                        echo "<script type='text/javascript'>alert('Inscription réussie');</script>
                        <script>window.location = 'connection.php'</script>";
                    }
                }
            }
        }
    }
}


require_once('header/header.php')

?>

<main>

    <div class="row">

        <h2 class="text-center mt-3 mb-5">Inscription</h2>

        <div class="col-3"></div>

        <div class="col-6">

            <form method="post">
                <div class="form-group mb-2">
                    <label for="pseudo">Pseudo</label><span class="error" style="color: #FF0000;"><?php echo " " . $pseudoErr;?></span>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo;?>" placeholder="Entrez votre pseudo">
                </div>
                <div class="form-group mb-2">
                    <label for="nom">Nom</label><span class="error" style="color: #FF0000;"><?php echo " " . $nomErr;?></span>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom;?>" placeholder="Entrez votre nom">
                </div>
                <div class="form-group mb-2">
                    <label for="prenom">Prénom </label><span class="error" style="color: #FF0000;"><?php echo " " . $prenomErr;?></span>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom;?>" placeholder="Entrez votre prénom">
                </div>
                <div class="form-group mb-2">
                    <label for="pseudo">Téléphone</label><span class="error" style="color: #FF0000;"><?php echo " " . $telephoneErr;?></span>
                    <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone">
                </div>
                <div class="form-group mb-2">
                    <label for="pseudo">Votre sexe</label><span class="error" style="color: #FF0000;"><?php echo " " . $sexeErr;?></span>
                    <select class="form-select" id="sexe" name="sexe">
                        <option selected>Choisisez votre sexe</option>
                        <option value="1">Homme</option>
                        <option value="2">Femme</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="email">Email address</label><span class="error" style="color: #FF0000;"><?php echo " " . $mailErr;?></span>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Entrez votre email">
                </div>
                <div class="form-group mb-2">
                    <label for="motDePasse">Mot de Passe</label><span class="error" style="color: #FF0000;"><?php echo " " . $mdpErr;?></span>
                    <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>

        </div>

        <div class="col-3"></div>

    </div>
</main>


<?php

require_once('footer/footer.php')


?>