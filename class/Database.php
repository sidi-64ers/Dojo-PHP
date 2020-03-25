<?php

class Database
{
    private $pdo;

    public function __construct($login, $password, $database_name,  $host = 'localhost')
    {
        $this->pdo = new PDO("mysql:host=$host;dbname=$database_name;charset=utf8", $login, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * @param $query
     * @param bool|array
     * @return PDOStatement
     */
    public function query($query, $params = false)
    {
        if ($params) {
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        } else {
            $req = $this->pdo->query($query);
        }
        return $req;
    }

    public function lastInsertId(){

        return $this->pdo->lastInsertId();

    }
}
