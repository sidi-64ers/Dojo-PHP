<?php

class Router  {

    public function __construct($target, $valueInitIndex) {
        $this->getTemplate($target, $valueInitIndex);
    }
    
    public function getTemplate($target, $valueInitIndex) {

        if (empty($_GET)) {  // if $_GET is empty, accueil.php is loaded
            include "template/$valueInitIndex";
        } else if (isset($_GET['page'])) {
            if (array_key_exists($_GET['page'], $target)) {
                include "template/".$_GET['page'].".php";
            } else {
                echo "<h1 style='color:red;'>404<br>
                    Cette page n'habite plus à cette adresse</h1>";
            }
        }
    }
}   