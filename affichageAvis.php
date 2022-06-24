<?php require_once('config/config.php');



if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

$id = $_GET['id'];

require_once('header/header.php');
?>

<main>
    
</main>

<?php

require_once('footer/footer.php')


?>