<?php 

require "init_db.php";

function crearUsuario($pdo, $nombre, $correo, $contrasena) {
    $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $correo, $contrasena]); 
}

function leerUsuarios($pdo) {
    $sql = "SELECT id, nombre, correo, fecha_creacion FROM usuarios ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);  
    return $usuarios; 
}