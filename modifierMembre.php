<?php require_once('config/config.php');

require_once('header/header.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

// On récupère l'id du membre séléctionné sur la page précedente

$id = $_GET['id'];

// Demande d'update pour chaque collone séparémant

// Pseudo

if (!empty($_POST['pseudo'])) {       
    $pseudo = trim($_POST['pseudo']);
    $stmt = $pdo->prepare("SELECT * FROM membre WHERE pseudo=?");
    $stmt->execute([$pseudo]);
    $user = $stmt->fetch();
    if ($user) {
        echo "<script type='text/javascript'>alert('Pseudo déjà pris');</script>";           
    }   
    else     
    {
    $inscription = $pdo->prepare("UPDATE membre SET pseudo = :pseudo WHERE id_membre = $id");
    $inscription->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
        <script>window.location = 'membres.php'</script>
    ";
}
}

// Nom

if (!empty($_POST['nom'])) {
    $nom = trim($_POST['nom']);
    $inscription = $pdo->prepare("UPDATE membre SET nom = :nom WHERE id_membre = $id");
    $inscription->bindParam(':nom', $nom, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
    <script>window.location = 'membres.php'</script>
    ";
}

// Prenom

if (!empty($_POST['prenom'])) {
    $prenom = trim($_POST['prenom']);
    $inscription = $pdo->prepare("UPDATE membre SET prenom = :prenom WHERE id_membre = $id");
    $inscription->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
    <script>window.location = 'membres.php'</script>
    ";
}

// Sexe

if (!empty($_POST['sexe']) && $_POST['sexe'] !== 'Choisissez') {
    $sexe = trim($_POST['sexe']);
    $inscription = $pdo->prepare("UPDATE membre SET civilite = :sexe WHERE id_membre = $id");
    $inscription->bindParam(':sexe', $sexe, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
    <script>window.location = 'membres.php'</script>
    ";
}

// Mail

if (!empty($_POST['mail'])) {
    $mail = trim($_POST['mail']);
    $stmt = $pdo->prepare("SELECT * FROM membre WHERE email=?");
    $stmt->execute([$mail]);
    $user = $stmt->fetch();
    if ($user) {
        echo "<script type='text/javascript'>alert('Mail déjà pris');</script>";           
    }   
    else     
    {
    $inscription = $pdo->prepare("UPDATE membre SET email = :mail WHERE id_membre = $id");
    $inscription->bindParam(':mail', $mail, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
    <script>window.location = 'membres.php'</script>
    ";
}
}

// Mot De Passe

// if (!empty($_POST['motDePasse'])) {
//     $mdp = trim($_POST['motDePasse']);
//     $hashed_mdp = password_hash($mdp, PASSWORD_BCRYPT);
//     $inscription = $pdo->prepare("UPDATE membre SET mdp = :mdp WHERE id_membre = $id");
//     $inscription->bindParam(':mdp', $hashed_mdp, PDO::PARAM_STR);
//     $inscription->execute();

//     echo "<script type='text/javascript'>alert('Modification réussie');</script>
//     <script>window.location = 'listeMembres.php'</script>
//     ";
// }

// Admin ou non

if (isset($_POST['statut']) && $_POST['statut'] !== 'Choisissez') {
    $statut = trim($_POST['statut']);
    $inscription = $pdo->prepare("UPDATE membre SET statut = :statut WHERE id_membre = $id");
    $inscription->bindParam(':statut', $statut, PDO::PARAM_STR);
    $inscription->execute();

    echo "<script type='text/javascript'>alert('Modification réussie');</script>
    <script>window.location = 'membres.php'</script>
    ";
}

// Téléphone

if (!empty($_POST['telephone'])) {
    $telephone = trim($_POST['telephone']);
    if (!is_numeric($telephone)) {   
        echo "<script type='text/javascript'>alert('Veullez entrer un numéro de tél');</script>";
    }
    else
    {   
        $inscription = $pdo->prepare("UPDATE membre SET telephone = :telephone WHERE id_membre = $id");
        $inscription->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $inscription->execute();
 
        echo "<script type='text/javascript'>alert('Modification réussie');</script>
        <script>window.location = 'membres.php'</script>
        ";    
    }
}




?>

<main>

    <div class="row mt-5">

    <!-- Titre de la page -->

    <h2 class="text-center mb-5">Modification des informations du membre numéro <?php echo "$_GET[id]" ?></h2>

    <div class="row">


        <div class="col-1"></div>

        <div class="col-10">

            <!-- Formulaire pour les modifications du membre séléctionné -->

            <form method="post" class="row">

                <div class="col-5">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Son pseudo">
                    </div>
                    <!-- <div class="mb-3">
                        <label for="motDePasse" class="form-label">Mot De Passe</label>
                        <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Son mot de passe">
                    </div> -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Son nom">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Son prénom">
                    </div>
            
                </div>

                <div class="col-2"></div>

                <div class="col-5">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="mail" name="mail" placeholder="Son email">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Son numéro de téléphone">
                    </div>
            
                    <div class="mb-3">
                        <label for="civilite" class="form-label">Civilité</label>
                        <select class="form-select"  id="sexe" name="sexe" >
                            <option selected>Choisissez</option> 
                            <option value="1">Homme</option>
                            <option value="2">Femme</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select"  id="statut" name="statut" > 
                            <option selected>Choisissez</option>      
                            <option value="1">Admin</option>
                            <option value="0">Client</option>
                        </select>
                    </div>
            
                </div>

                <div class="col-12 text-center mt-5">
                    <button type="submit" class="btn btn-primary col-1">Submit</button>
                </div>
            </form>
            

        </div>
 

        <div class="col-1"></div>


    </div>



    </div>


</main>

<?php

require_once('footer/footer.php')


?>