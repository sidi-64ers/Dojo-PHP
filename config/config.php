<?php 
// title
define("title", "Dojos BlogPHP");

// nav, footer
define("nav", "inc/header.php");
define("footer", "inc/footer.php");
 
//Images, CSS
define("cheminImages", "assets/img"); 
define("cheminCss", "./assets/css/style.css"); 

// Rooter
define('root', ['accueil' => 'accueil.php',
                'login' => 'login.php',
                'compte' => 'compte.php',
                'register' => 'register.php',
                'forget' => 'forget.php', 
                'reset' => 'reset.php',
                'confirmation' => 'confirmation.php',
                'logout' => 'logout.php',
                'categorie' => 'categorie.php'
                ])
?>