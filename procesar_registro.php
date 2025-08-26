<?php
session_start();
require_once 'includes/conexion.php';
require_once 'includes/funciones.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: registrarse.php");
    exit();
}

// Recoger y sanitizar datos
$id_usuario = limpiarEntrada($_POST['id_usuario']);
$nombre = limpiarEntrada($_POST['nombre']);
$apellido_paterno = limpiarEntrada($_POST['apellido_paterno']);
$apellido_materno = limpiarEntrada($_POST['apellido_materno']);
$edad = intval($_POST['edad']);
$sexo = limpiarEntrada($_POST['sexo']);
$email = limpiarEntrada($_POST['email']);
$telefono = limpiarEntrada($_POST['telefono']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validaciones
$errores = [];

// 1. Validar campos vacíos
$campos_requeridos = [
    'ID de Usuario' => $id_usuario,
    'Nombre' => $nombre,
    'Apellido Paterno' => $apellido_paterno,
    'Apellido Materno' => $apellido_materno,
    'Edad' => $edad,
    'Sexo' => $sexo,
    'Email' => $email,
    'Teléfono' => $telefono,
    'Contraseña' => $password,
    'Confirmación de contraseña' => $confirm_password
];

foreach($campos_requeridos as $campo => $valor) {
    if(empty($valor)) {
        $errores[] = "El campo $campo es obligatorio.";
    }
}

// 2. Validar formato del ID de usuario
if(!preg_match('/^\d{4}$/', $id_usuario)) {
    $errores[] = "El ID de usuario debe ser un número de 4 dígitos.";
}

// 3. Validar que el ID no exista
try {
    // Usando el nombre completo de tu base de datos
    $stmt = $conn->prepare("SELECT IDUsuario FROM b7_39514274_INSTITUTO.usuarios WHERE IDUsuario = ?");
    $stmt->execute([$id_usuario]);
    
    if($stmt->rowCount() > 0) {
        $errores[] = "El ID de usuario ya está registrado.";
    }
} catch(PDOException $e) {
    $errores[] = "Error al verificar el ID de usuario: " . $e->getMessage();
}

// 4. Validar formato del email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El formato del correo electrónico no es válido.";
} else {
    // Verificar que el email no exista
    try {
        $stmt = $conn->prepare("SELECT Email FROM b7_39514274_INSTITUTO.usuarios WHERE Email = ?");
        $stmt->execute([$email]);
        
        if($stmt->rowCount() > 0) {
            $errores[] = "El correo electrónico ya está registrado.";
        }
    } catch(PDOException $e) {
        $errores[] = "Error al verificar el correo electrónico: " . $e->getMessage();
    }
}

// 5. Validar formato del teléfono
if(!preg_match('/^\d{10}$/', $telefono)) {
    $errores[] = "El teléfono debe contener 10 dígitos numéricos.";
}

// 6. Validar contraseña
if($password != $confirm_password) {
    $errores[] = "Las contraseñas no coinciden.";
}

if(strlen($password) < 8) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres.";
}

if(!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
    $errores[] = "La contraseña debe contener letras y números.";
}

if(!preg_match('/[#\$\-_&%]/', $password)) {
    $errores[] = "La contraseña debe contener al menos un carácter especial (#,$,-,_,&,%).";
}

// Si hay errores, redirigir al formulario
if(!empty($errores)) {
    $error_msg = implode("\\n", $errores);
    header("Location: registrarse.php?error=" . urlencode($error_msg));
    exit();
}

// Hash de la contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insertar nuevo usuario
try {
    $stmt = $conn->prepare("INSERT INTO b7_39514274_INSTITUTO.usuarios (IDUsuario, Nombre, ApellidoPaterno, ApellidoMaterno, Edad, Sexo, Email, Telefono, TipoUsuario, Password) 
                            VALUES (:id, :nombre, :apellido_p, :apellido_m, :edad, :sexo, :email, :telefono, 'ES', :pass)");
    
    $stmt->bindParam(':id', $id_usuario);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido_p', $apellido_paterno);
    $stmt->bindParam(':apellido_m', $apellido_materno);
    $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':pass', $password_hash);
    
    $stmt->execute();
    
    header("Location: registrarse.php?success=" . urlencode("Registro exitoso. Ahora puedes iniciar sesión."));
    exit();
} catch(PDOException $e) {
    $error_msg = "Error al registrar el usuario: " . $e->getMessage();
    header("Location: registrarse.php?error=" . urlencode($error_msg));
    exit();
}
?>