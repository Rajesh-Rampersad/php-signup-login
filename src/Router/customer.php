<?php

namespace Router;

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Importar la clase db
use db;

// Crear el contenedor
$container = new \Slim\Container();

// Crear la instancia de la aplicación
$app = new AppFactory($container);

// GET Todos los clientes 
$app->get('/api/clientes', function(Request $request, Response $response){
    $sql = "SELECT * FROM clientes";
    try{
        $db = new db(); // Utilizar la clase db
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
            $clientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
            // Devolver respuesta en formato JSON
            return $response->withJson($clientes);
        } else {
            // Devolver mensaje JSON
            return $response->withJson("No existen clientes en la BBDD.");
        }
    } catch(PDOException $e){
        // Devolver mensaje JSON con el error
        return $response->withJson(['error' => ['text' => $e->getMessage()]]);
    }
}); 
// GET Recuperar cliente por ID 
$app->get('/api/clientes/{id}', function(Request $request, Response $response){
    $id_cliente = $request->getAttribute('id');
    $sql = "SELECT * FROM clientes WHERE id = :id";
    try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->bindParam(':id', $id_cliente);
        $resultado->execute();

        if ($resultado->rowCount() > 0){
            $cliente = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($cliente);
        } else {
            echo json_encode("No existen cliente en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
    } catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
}); 

// POST Crear nuevo cliente 
$app->post('/api/clientes/nuevo', function(Request $request, Response $response){
    $data = $request->getParsedBody();
    $sql = "INSERT INTO clientes (nombre, apellidos, telefono, email, direccion, ciudad) 
            VALUES (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";
    try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->execute($data);
        echo json_encode("Nuevo cliente guardado.");  
        $resultado = null;
        $db = null;
    } catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
}); 

// PUT Modificar cliente 
$app->put('/api/clientes/modificar/{id}', function(Request $request, Response $response){
    $id_cliente = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $sql = "UPDATE clientes SET
            nombre = :nombre,
            apellidos = :apellidos,
            telefono = :telefono,
            email = :email,
            direccion = :direccion,
            ciudad = :ciudad
            WHERE id = :id";
    $data['id'] = $id_cliente;
    try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->execute($data);
        echo json_encode("Cliente modificado.");  
        $resultado = null;
        $db = null;
    } catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
}); 

// DELETE borrar cliente 
$app->delete('/api/clientes/delete/{id}', function(Request $request, Response $response){
    $id_cliente = $request->getAttribute('id');
    $sql = "DELETE FROM clientes WHERE id = :id";
    try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->bindParam(':id', $id_cliente);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            echo json_encode("Cliente eliminado.");  
        } else {
            echo json_encode("No existe cliente con este ID.");
        }

        $resultado = null;
        $db = null;
    } catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
}); 
return $app;