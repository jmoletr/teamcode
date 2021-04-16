<?php
    $servidor="mysql:dbname=p6_teamcode; host=localhost:8889";
    $usuario="root";
    $password="root";

    try{
        $pdo= new PDO($servidor, $usuario, $password);
        //echo "Conectado a la Base de Datos correctamente";

    }catch(PDOException $e){
        echo "Error de conexión con la base de datos ".$e->getMessage();
    }

?>
