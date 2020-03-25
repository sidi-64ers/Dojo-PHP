<?php
spl_autoload_register('chargerClass');

function chargerClass($class) {
    require "class/$class.php";
}
