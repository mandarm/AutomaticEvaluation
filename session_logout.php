<?php require_once("./includes/header.php"); ?>


hello
<?php 
	session_start();
    session_destroy();
    header("Refresh:0;url=./index.php");

    ?>


<?php require_once("./includes/footer.php"); ?>