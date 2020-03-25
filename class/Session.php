<?php
class Session {

    // Singleton qui sauvegarde l'instance de la session
    static $instance;

    static function getInstance() {
        // S'il n'y a pas déjà eu d'instance de session, j'instancie
        if (!self::$instance) {
            self::$instance = new Session;
        }
        return self::$instance;
    }
    /**
     * Initialise la session
     */
    public function __construct() {
        session_start();
    }
    /**
     * Définit un message flash
     */
    public function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }
    /** 
     * Condition s'il y a des messages flash en mémoire
     * @return 
     */
    public function hasFlashes() {
        return isset($_SESSION['flash']);
    }
    /**
     * Afficher les emssages flash
     */
    public function getFlashes() {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash'] );
        return $flash;
    }
    /**
     * Permet de créer des variables de session
     */
    public function write($key, $value) {
        $_SESSION[$key] = $value;
    }
    /**
     * Getter pour les variables de sessions
     * if ternaire
     */
    public function read($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    public function delete($key) {
        unset($_SESSION[$key]);
    }
    
}