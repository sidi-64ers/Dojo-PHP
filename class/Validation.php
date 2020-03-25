<?php

class Validation
{

    private $data;
    private $erreurs = [];

    public function __construct($data)
    {
        $this->data = $data;
    }
    private function getField($field) 
    {
        if (!isset($this->data[$field])) {
            return null;
        }
        return $this->data[$field];
    }
    public function isAlpha($field, $erreurMsg)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field)) ){
            $this->erreurs[$field] = $erreurMsg;
        }
    }
    public function isUniq($field, $db, $table,$erreurMsg)
    {
        $record = $db->query("SELECT id_user FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();
            
        if ($record) {
            $this->erreurs[$field] = $erreurMsg;
        }
    }

    public function isEmail($field, $erreurMsg) {
        // function filter_var qui test si c'est un émail second paramètre qui détermine le filtre à utiliser 
        // return true ou false
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->erreurs[$field] = $erreurMsg;
        }
    }

    public function isConfirmed($field, $erreurMsg = '') {
        if(empty($this->getField($field)) || $this->getField($field) != $this->getField($field . "_confirm")) {
            $this->erreurs[$field] = $erreurMsg;
            
        }
    }

    public function isValid() {
        // Si tableau vide return true donc pas de message d'erreurs
        return empty($this->erreurs);
    }
    public function getErreurs() {
        // Si tableau vide return true donc pas de message d'erreurs
        return $this->erreurs;
    }
}
