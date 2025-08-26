<?php
session_start();
require_once 'includes/conexion.php';
require_once 'includes/funciones.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: login.php");
    exit();
}

$id_usuario = limpiarEntrada($_POST['id_usuario']);
$password = $_POST['password'];

// Validaciones básicas
if(empty($id_usuario) || empty($password)) {
    header("Location: login.php?error=" . urlencode("Todos los campos son obligatorios"));
    exit();
}

// Buscar usuario en la base de datos
try {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE IDUsuario = ?");
    $stmt->execute([$id_usuario]);
    
    if($stmt->rowCount() == 0) {
        header("Location: login.php?error=" . urlencode("Usuario no registrado"));
        exit();
    }
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar contraseña
    if(!password_verify($password, $usuario['Password'])) {
        header("Location: login.php?error=" . urlencode("Contraseña incorrecta"));
        exit();
    }
    
    // Configurar sesión
    $_SESSION['id_usuario'] = $usuario['IDUsuario'];
    $_SESSION['nombre'] = $usuario['Nombre'];
    $_SESSION['apellido_paterno'] = $usuario['ApellidoPaterno'];
    $_SESSION['apellido_materno'] = $usuario['ApellidoMaterno'];
    $_SESSION['tipo_usuario'] = $usuario['TipoUsuario'];
    $_SESSION['ultimo_acceso'] = time();
    
    // Redirigir según tipo de usuario
    if($usuario['TipoUsuario'] == 'CE') {
        header("Location: dashboard_ce.php");
    } else {
        header("Location: dashboard_es.php");
    }
    exit();
    
} catch(PDOException $e) {
    error_log("Error en login: " . $e->getMessage());
    header("Location: login.php?error=" . urlencode("Error al iniciar sesión. Por favor intente más tarde."));
    exit();
}
?>
