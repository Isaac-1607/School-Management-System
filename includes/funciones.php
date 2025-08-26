<?php
function limpiarEntrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validarPassword($password) {
    // Longitud mínima de 8 caracteres
    if(strlen($password) < 8) {
        return false;
    }
    
    // Debe contener al menos una letra y un número
    if(!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        return false;
    }
    
    // Debe contener al menos un carácter especial
    if(!preg_match('/[#\$\-_&%]/', $password)) {
        return false;
    }
    
    return true;
}

function generarNavbar($tipo_usuario) {
    $nav = '<nav><ul>';
    $nav .= '<li><a href="index.php">Inicio</a></li>';
    
    if($tipo_usuario) {
        $nav .= '<li><a href="consultar.php">Consultar</a></li>';
        $nav .= '<li><a href="registrar_examen.php">Registrar</a></li>';
        
        if($tipo_usuario == 'CE') {
            $nav .= '<li><a href="modificar.php">Modificar</a></li>';
            $nav .= '<li><a href="eliminar.php">Eliminar</a></li>';
        }
        
        $nav .= '<li><a href="logout.php">Salir</a></li>';
    } else {
        $nav .= '<li><a href="registrarse.php">Registrarse</a></li>';
        $nav .= '<li><a href="login.php">Iniciar sesión</a></li>';
    }
    
    $nav .= '</ul></nav>';
    return $nav;
}
?>