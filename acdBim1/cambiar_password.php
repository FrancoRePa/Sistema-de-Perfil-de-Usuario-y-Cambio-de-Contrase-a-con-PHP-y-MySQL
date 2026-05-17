<?php
session_start();

if (!isset($_SESSION['id_tecnico'])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

$mensaje = "";
$cedula_real = $_SESSION['id_tecnico'];

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['captcha_seguridad'] = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $password_confirmar = $_POST['password_confirmar'];
    $codigo_usuario = strtoupper(trim($_POST['codigo_seguridad']));

    if ($codigo_usuario !== $_SESSION['captcha_seguridad']) {
        $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>El código de verificación es incorrecto. Intente de nuevo.</div>";
        $_SESSION['captcha_seguridad'] = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    } else {
        $sql_buscar = "SELECT password FROM tecnicos WHERE cedula = '$cedula_real'";
        $resultado = $conexion->query($sql_buscar);
        
        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            
            if (password_verify($password_actual, $usuario['password'])) {
                
                if ($password_nueva === $password_confirmar) {
                    
                    $nueva_encriptada = password_hash($password_nueva, PASSWORD_DEFAULT);
                    
                    $sql_update = "UPDATE tecnicos SET password = '$nueva_encriptada' WHERE cedula = '$cedula_real'";
                    
                    if ($conexion->query($sql_update) === TRUE) {
                        $mensaje = "<div class='alert alert-success text-center fw-bold shadow-sm'>¡Contraseña actualizada con éxito!</div>";
                    } else {
                        $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>Error al actualizar: " . $conexion->error . "</div>";
                    }
                    
                } else {
                    $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>Las nuevas contraseñas no coinciden entre sí.</div>";
                }
                
            } else {
                $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>La contraseña actual es incorrecta.</div>";
            }
        }
        
        $_SESSION['captcha_seguridad'] = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    }
}

$nombres_real = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : '';
$apellidos_real = isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - IPASB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="w-100 bg-white shadow-sm text-center">
        <img src="imgs/logoIpasb.png" class="img-fluid" alt="Logo de IPASB" style="max-height: 300px; width: 100%; object-fit: cover;">
    </div>

    <div class="container my-5">
        <div class="row g-4">
            
            <div class="col-md-3">
                <div class="card shadow-sm border-0 p-3" style="border-radius: 12px;">

                    <div class="text-center my-2">
                        <h6 class="fw-bold text-dark mb-0"><?php echo $nombres_real . " " . $apellidos_real; ?></h6>
                        <p class="text-muted small mb-0">Técnico(a) de Territorio</p>
                    </div>

                    <hr class="opacity-25 my-2">
                    
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link text-secondary fw-semibold mb-2" href="perfil.php">
                            Mi Perfil / Editar Datos
                        </a>
                        <a class="nav-link active fw-semibold mb-2" href="cambiar_password.php" style="background-color: #003366;">
                            Cambiar Contraseña
                        </a>
                        <hr class="opacity-25 my-2">
                        <a class="nav-link btn btn-outline-danger text-danger fw-bold text-center py-2 mt-2" href="logout.php">
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                
                <div class="card shadow-sm border-0 mb-4 p-4 text-white" style="background-color: #003366; border-radius: 12px;">
                    <h2 class="h4 fw-bold mb-1">Seguridad de la Cuenta</h2>
                </div>

                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-dark mb-3">Modificar Contraseña</h3>
                        <p class="text-muted small mb-4">Todos los campos son obligatorios. No olvide repetir el código dinámico.</p>
                        
                        <?php echo $mensaje; ?>
                        
                       <form action="cambiar_password.php" method="POST">
    
                            <div class="mb-3">
                                <label for="password_actual" class="form-label fw-semibold">Contraseña Actual</label>
                                <input type="password" class="form-control" id="password_actual" name="password_actual" placeholder="Ingrese su contraseña" required>
                            </div>

                            <hr class="opacity-25 my-4">

                            <div class="mb-3">
                                <label for="password_nueva" class="form-label fw-semibold">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password_nueva" name="password_nueva" placeholder="Mínimo 6 caracteres" minlength="6" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmar" class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmar" name="password_confirmar" placeholder="Repita la nueva contraseña" minlength="6" required>
                            </div>

                            <hr class="opacity-25 my-4">

                            <div class="mb-3 p-3 bg-light rounded border">
                                <label for="codigo_seguridad" class="form-label fw-bold text-dark">Verificación de Seguridad Institucional</label>
                                <p class="text-muted small mb-2">Escriba el código de validación que ve a continuación:</p>
                                
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <div class="bg-secondary text-white px-4 py-2 fw-bold fs-4 rounded shadow-sm tracking-widest unselectable" 
                                        style="letter-spacing: 5px; font-family: monospace; user-select: none; background-color: #343a40 !important;">
                                        <?php echo $_SESSION['captcha_seguridad']; ?>
                                    </div>
                                    <span class="text-muted small text-decoration-underline" style="cursor: pointer;" onclick="window.location.reload();">
                                        Generar otro código
                                    </span>
                                </div>
                                
                                <input type="text" class="form-control text-center fw-bold" id="codigo_seguridad" name="codigo_seguridad" 
                                    maxlength="6" autocomplete="off" style="max-width: 200px; letter-spacing: 2px;" required>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                                    Cambiar contraseña
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>