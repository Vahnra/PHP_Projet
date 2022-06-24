<?php require_once('config/config.php');

require_once('header/header.php');

if (!isset($_SESSION["admin"])) {
    header("location: index.php");
    exit; 
}

$id = $_GET['id'];

?>

<main>
    
</main>

<?php

require_once('footer/footer.php')


?>