<?php 
/**
 * Gère les chaîne de caractères à traiter
 */
class Str {

    static function random($length) {
        $alphabet = "0123456789zertyuiopqsdfghklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)),0, $length);
    }
}