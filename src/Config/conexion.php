<?php

class db {
    private $dbHost = 'localhost';
    private $dbUser = 'postgres';
    private $dbPass = '';
    private $dbName = 'painel';

    // conexión
    public function conectDB() {
        try {
            $pdo = new PDO("pgsql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit();
        }
    }
}
