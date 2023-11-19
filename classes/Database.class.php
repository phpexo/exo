<?php
class Database {

private $config;
private $db;

public function __construct() {
    $this->config = require(dirname(__DIR__).'/config/database.config.php');

    try {
        $this->db = new PDO(
            $this->config['driver'] . ':host=' . $this->config['host'] . ';dbname=' . $this->config['dbname'],
            $this->config['username'],
            $this->config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    } catch (PDOException $e) {
        die('Verbindung zur Datenbank fehlgeschlagen: ' . $e->getMessage());
    }
}

public function getDb() {
    return $this->db;
}

public function prepare($sql) {
    return $this->db->prepare($sql);
}

public function query($sql) {
    return $this->db->query($sql);
}

public function lastInsertId($sql) {
    return $this->db->lastInsertId($sql);
}


}

?>
