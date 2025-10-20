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

function actualizarUsuario($pdo, $id, $nuevo_nombre, $nuevo_correo) { 
    $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nuevo_nombre, $nuevo_correo, $id]);
}

function borrarUsuario($pdo, $id) {
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}



$mensaje = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        if (!empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['contrasena'])) {
            try {
                if (crearUsuario($pdo, $_POST['nombre'], $_POST['correo'], $_POST['contrasena'])) {
                    $mensaje = ' Usuario creado con éxito.';
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $mensaje = ' Error: El correo ya está registrado.';
                } else {
                    $mensaje = ' Error al crear: ' . $e->getMessage();
                }
            }
        }
    }

    // Lógica de Actualización
    if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
        if (!empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['correo'])) {
            if (actualizarUsuario($pdo, $_POST['id'], $_POST['nombre'], $_POST['correo'])) { 
                $mensaje = 'Usuario ID ' . $_POST['id'] . ' actualizado con éxito.';
            } else {
                $mensaje = 'No se realizó ninguna modificación.';
            }
        }
    }

    if (isset($_POST['accion']) && $_POST['accion'] === 'borrar') {
        if (!empty($_POST['id'])) {
            if (borrarUsuario($pdo, $_POST['id'])) {
                $mensaje = 'Usuario ID ' . $_POST['id'] . ' eliminado.';
            } else {
                $mensaje = 'Error: No se pudo eliminar el usuario.';
            }
        }
    }
    
    $redirect_msg = urlencode($mensaje);
    header("Location: index.php?msg=" . $redirect_msg);
    exit();
}


$usuarios = leerUsuarios($pdo);

?>