<?php 

if(ISSET($_POST['login'])){
    if($_POST['mail'] != "" || $_POST['motDePasse'] != "")
    {
        $mail = $_POST['mail'];
        $sql = "SELECT * FROM membre WHERE email=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($mail));
        $fetch = $query->fetch();
        if($fetch && password_verify($_POST['motDePasse'], $fetch['mdp'])) 
        {
            $_SESSION['user'] = $fetch['id_membre'];
            $_SESSION['admin'] = $fetch['statut'];
            $_SESSION['prenom'] = $fetch['prenom'];
            echo "<script type='text/javascript'>alert('Connexion réussi !');</script>";

        } 
        else
        {
            echo "
            <script>alert('Mauvais mot de passe ou mail')</script>
            <script>window.location = 'index.php'</script>
            ";
        }
    }
    else
    {
        echo "
            <script>alert('Entrez tout les infos')</script>
            ";
    }
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/25e8e4b41e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Deal</title>
</head>

<body>

    <!-- Navbar -->

    <header class="sticky-top">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand ms-5" href="index.php">Deal</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Qui Sommes Nous</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>

                        <!-- Menu admin -->

                        <?php if (!empty($_SESSION)) {

                            if ($_SESSION['admin'] == 1) {
                                echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administrateur</a> 
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="membres.php">Gestion des membres</a></li>
                            <li><a class="dropdown-item" href="categorie.php">Gestion des catégories</a></li>
                            <li><a class="dropdown-item" href="commentaire.php">Gestion des commentaires</a></li>
                            <li><a class="dropdown-item" href="annonce.php">Gestion des annonces</a></li>
                            <li><a class="dropdown-item" href="avis.php">Gestion des avis</a></li>
                        </ul>
                    </li>
                    ';
                            }
                        }
                        ?>

                    </ul>
                    <form class="d-flex me-auto my-auto" style="width: 40vw;">
                        <input class="form-control" type="search" placeholder="Recherche..." aria-label="Search">
                    </form>
                    <ul class="navbar-nav">

                        <!-- Profile et déconnecter -->

                        <?php if (!empty($_SESSION)) {
                            echo '
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Espace Membre</a> 
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="ajouterAnnonce.php"">Poster une annonce</a></li>
                            <li><a class="dropdown-item" href="logout.php"">Deconnexion</a></li>
                        </ul>
                    </li>

                    ';
                        } else {
                            echo '

                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Espace Membre</a> 
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#modal" data-bs-toggle="modal" data-bs-target="#modal1">Connection</a></li>
                            <li><a class="dropdown-item" href="inscription.php"">Inscription</a></li>
                        </ul>
                    </li>
                    ';
                        }
                        ?>



                </div>
                </ul>
            </div>
        </nav>

    </header>

    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Connection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="mail" name="mail" placeholder="Entrez votre email">
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Mot de Passe</label>
                            <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Password">
                        </div>
                        <button type="submit" name="login" class="btn btn-primary mt-4">Confirmer</button>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>