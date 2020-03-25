<?php

class Article {

    private $pdo;

    public function __construct() {
        $this->pdo = App::getDatabase();
    }
    
    public function findAll() {
        
        $resultat = $this->pdo->query("SELECT * FROM articles");
        $resultat->execute();
        $articles = $resultat->fetchAll(PDO::FETCH_ASSOC);

        return $articles;
    }

    public function findByCategorie($categorie) {

    $resultat = $this->pdo->query("SELECT * FROM viewBlog WHERE nom_categorie = `bonheur`" );
    $resultat->execute();
    $articlesByCategorie = $resultat->fetchAll(PDO::FETCH_ASSOC);

    return $articlesByCategorie;
    }
}
