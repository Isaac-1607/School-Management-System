<?php
require_once __DIR__ . '/../includes/conexion.php';
session_start();

$mensaje_exito = '';
$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener datos del formulario
    $id_usuario = trim($_POST['id_usuario'] ?? $_SESSION['id_usuario']);
    $asignatura = trim($_POST['asignatura'] ?? '');
    $docente    = trim($_POST['docente'] ?? '');
    $fecha      = trim($_POST['fecha'] ?? '');
    $hora       = trim($_POST['hora'] ?? '');
    $aula       = trim($_POST['aula'] ?? '');

    // Validar campos obligatorios
    if (empty($id_usuario) || empty($asignatura) || empty($docente) || empty($fecha) || empty($hora) || empty($aula)) {
        $mensaje_error = "⚠️ Faltan campos obligatorios";
    } else {
        try {
            // Ajuste de nombres de columnas según tu tabla
            $sql = "INSERT INTO examenes 
                    (IDUsuario, Asignatura, DocenteAsignatura, FechaAplicacion, HoraAplicacion, AulaAplicacion) 
                    VALUES (:id_usuario, :asignatura, :docente, :fecha, :hora, :aula)";
            $stmt = $conn->prepare($sql); // ← usar $conn en lugar de $pdo

            // Bind de parámetros
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':asignatura', $asignatura);
            $stmt->bindParam(':docente', $docente);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':aula', $aula);

            if ($stmt->execute()) {
                // Redirigir con mensaje de éxito
                header("Location: ../examenes/registrar_examen.php?exito=" . urlencode("✅ Examen extraordinario registrado correctamente"));
                exit();
            } else {
                $mensaje_error = "⚠️ Ocurrió un error al registrar el examen";
            }
        } catch (PDOException $e) {
            $mensaje_error = "❌ Error en la base de datos: " . $e->getMessage();
        }
    }
}

// Si hubo error, redirigir con mensaje de error
if ($mensaje_error) {
    header("Location: ../examenes/registrar_examen.php?error=" . urlencode($mensaje_error));
    exit();
}
?>
