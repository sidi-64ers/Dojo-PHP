<?php

$db = App::getDatabase();


if (App::getAuth()->confirmation($db, $_GET['id'], $_GET['token']) ) {
    Session::getInstance()->setFlash('succes', "Votre compte a bien été créé" );
    App::redirect('index.php?page=compte.php');
} else {
    Session::getInstance()->setFlash('danger', "Utilise un token valide" );
    App::redirect('index.php?page=login.php');
}
