<?php require_once('config/config.php');

require_once('header/header.php');


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
            header("location: index.php");
        } 
        else
        {
            echo "
            <script>alert('Mauvais mot de passe ou mail')</script>
            <script>window.location = 'connection.php'</script>
            ";
        }
    }
    else
    {
        echo "
            <script>alert('Entrez tout les infos')</script>
            <script>window.location = 'connection.php'</script>
            ";
    }
}

?>



<main>

    <div class="row">

        <h2 class="text-center mt-3">Connection a votre compte</h2>

        <div class="col-3"></div>

        <div class="col-6">

            <form method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Entrez votre email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de Passe</label>
                    <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Password">
                </div>
                <button type="submit" name="login" class="btn btn-primary mt-2">Submit</button>
            </form>

        </div>

        <div class="col-3"></div>

    </div>
</main>

<?php

require_once('footer/footer.php')


?>