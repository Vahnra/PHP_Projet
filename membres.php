<?php require_once('config/config.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

if (isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['sexe']) && isset($_POST['mail'])  && isset($_POST['motDePasse']) && isset($_POST['statut'])) {

    
    if ($_POST['pseudo'] == "" || $_POST['nom'] == "" || $_POST['prenom'] == "" || $_POST['telephone'] == "" || $_POST['sexe'] == "" || $_POST['mail'] == "" || $_POST['motDePasse'] == "" ) 
    {
       echo "<script>alert('Entrez tout les infos')</script>";
    } 
    else
    {
    $pseudo = trim($_POST['pseudo']);
    $stmt = $pdo->prepare("SELECT * FROM membre WHERE pseudo=?");
    $stmt->execute([$pseudo]);
    $user = $stmt->fetch();
    if ($user) {
        $pseudo = null;
        echo "<script>Pseudo deja utilisé</script>";
        
    }
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $telephone = trim($_POST['telephone']);
    $sexe = trim($_POST['sexe']);

    $mail = trim($_POST['mail']);
    $stmtd = $pdo->prepare("SELECT * FROM membre WHERE email=?");
    $stmtd->execute([$mail]);
    $user = $stmtd->fetch();
    if ($user) {
        $mail = null;
        echo "<script>Mail deja utilisé</script>";
    }

    $mdp = trim($_POST['motDePasse']);
    $hashed_mdp = password_hash($mdp, PASSWORD_BCRYPT);
    $statut = trim($_POST['statut']);

    $inscription = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :mail, :sexe, :statut, NOW())");
    $inscription->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $inscription->bindParam(':mdp', $hashed_mdp, PDO::PARAM_STR);
    $inscription->bindParam(':nom', $nom, PDO::PARAM_STR);
    $inscription->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $inscription->bindParam(':telephone', $telephone, PDO::PARAM_STR);
    $inscription->bindParam(':mail', $mail, PDO::PARAM_STR);
    $inscription->bindParam(':sexe', $sexe, PDO::PARAM_STR);
    $inscription->bindParam(':statut', $statut, PDO::PARAM_STR);
    $inscription->execute();

    header('location: membres.php');
}

}

if (isset($_POST['delete'])) {
    $deleted = $_POST['delete'];
    $reponse = $pdo->query("DELETE FROM membre WHERE id_membre = $deleted");
    echo "<script type='text/javascript'>alert('Membre supprimé');</script>
    <script>window.location = 'connection.php'</script>";
}

if (isset($_POST['inspecter'])) {
    $inspecter = $_POST['inspecter'];
    header("location: affichageMembres.php?id=$inspecter");
}

if (isset($_POST['modifier'])) {
    $modifier = $_POST['modifier'];
    header("location: modifierMembre.php?id=$modifier");
}

require_once('header/header.php');

?>

<main>

    <div class="row">

        <h2 class="text-center mt-4 mb-5">Gestion des membres</h2>

        <div class="col-1"></div>

        <div class="col-10 mx-auto mt-4 mb-4 text-center">

            <?php 

                $reponse = $pdo->query("SELECT id_membre, pseudo, nom, prenom, telephone, email, civilite, statut, date_enregistrement FROM membre");

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

                    

                    <button type='submit' class='btn btn-labeled btn-default' id='inspecter' name='inspecter' value='$ligne[id_membre]'>
                    <span class='btn-label'><i class='fa fa-search'></i></span></button>

                    <button type='submit' class='btn btn-labeled btn-default' id='modifier' name='modifier' value='$ligne[id_membre]' >
                    <span class='btn-label'><i class='fas fa-edit'></i></span></button>

                    <button type='submit' class='btn btn-labeled btn-default' id='delete' name='delete' value='$ligne[id_membre]' >
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

        <h3 class="text-center mb-5">Ajouter un membre</h3>

        <div class="col-1"></div>

        <div class="col-10">

            <form method="post" class="row">

                <div class="col-5">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo">
                    </div>
                    <div class="mb-3">
                        <label for="motDePasse" class="form-label">Mot De Passe</label>
                        <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Votre mot de passe">
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom">
                    </div>
            
                </div>

                <div class="col-2"></div>

                <div class="col-5">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="mail" name="mail" placeholder="Votre email">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Votre numéro de téléphone">
                    </div>
            
                    <div class="mb-3">
                        <label for="civilite" class="form-label">Civilité</label>
                        <select class="form-select"  id="sexe" name="sexe" >
                            <option value="1">Homme</option>
                            <option value="2">Femme</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select"  id="statut" name="statut" >       
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

   
          

</main>

<?php

require_once('footer/footer.php')


?>