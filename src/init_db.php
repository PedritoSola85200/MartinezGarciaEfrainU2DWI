<?php

$host = 'db';              
$db   = 'Mi_app';      
$user = 'root';        
$pass = '123'; 

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$sql_create_table = "
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(150) UNIQUE NOT NULL,
        contrasena VARCHAR(255) NOT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec($sql_create_table);
    

} catch (PDOException $e) {
    die(" Error al conectar o crear la tabla: " . $e->getMessage() . "\n");
}
?>