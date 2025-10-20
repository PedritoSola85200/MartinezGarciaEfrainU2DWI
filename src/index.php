<?php 

require "init_db.php";

function crearUsuario($pdo, $nombre, $correo, $contrasena) {
    $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $correo, $contrasena]); 
}