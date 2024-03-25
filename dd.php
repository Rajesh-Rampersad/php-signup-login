<?php
class db{
    private $dbHost ='localhost';
    private $dbUser = 'myUser';
    private $dbPass = 'NrTX577Fo9IiZEl9';
    private $dbName = 'panel';
    //conección 
    public function conectDB(){
        $pgsqlConnect = "pgsql:host=$this->dbHost;dbname=$this->dbName";
        $dbConnecion = new \PgSQL\PgSQL($pgsqlConnect, $this->dbUser, $this->dbPass);
        $dbConnecion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbConnecion;
    }
    //insertar
    public function insertClient($nombre, $apellidos, $telefono, $email, $direccion, $ciudad){
        $query = "INSERT INTO clientes (nombre, apellidos, telefono, email, direccion, ciudad) VALUES (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";
        $stmt = $this->conectDB()->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->execute();
        return $stmt->rowCount();
    }
    //eliminar
    public function deleteClient($id){
        $query = "DELETE FROM clientes WHERE id = :id";
        $stmt = $this->conectDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
    //actualizar
    public function updateClient($id, $nombre, $apellidos, $telefono, $email, $direccion, $ciudad){
        $query = "UPDATE clientes SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, email = :email, direccion = :direccion, ciudad = :ciudad WHERE id = :id";
        $stmt = $this->conectDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->execute();
        return $stmt->rowCount();
    }
    //buscar
    public function searchClient($id){
        $query = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conectDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    //listar
    public function listClients(){
        $query = "SELECT * FROM clientes";
        $stmt = $this->conectDB()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>