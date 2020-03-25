<?php 


App::getAuth()->logout();
Session::getInstance()->setFlash('Attention', "Vous êtes déconnecté" );

App::redirect('index.php?page=login');
