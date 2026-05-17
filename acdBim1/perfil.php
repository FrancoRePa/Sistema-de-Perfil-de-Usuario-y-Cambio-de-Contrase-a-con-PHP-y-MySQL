<?php
session_start();

if (!isset($_SESSION['id_tecnico'])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

$mensaje = "";
$cedula_real = $_SESSION['id_tecnico'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombres_nuevos = $_POST['nombres'];
    $apellidos_nuevos = $_POST['apellidos'];
    $nuevo_correo = $_POST['correo'];
    $nueva_fecha = $_POST['fecha_nacimiento'];

    $sql_update = "UPDATE tecnicos 
                   SET nombres = '$nombres_nuevos', 
                       apellidos = '$apellidos_nuevos', 
                       correo = '$nuevo_correo', 
                       fecha_nacimiento = '$nueva_fecha' 
                   WHERE cedula = '$cedula_real'";

    if ($conexion->query($sql_update) === TRUE) {
        $_SESSION['nombres'] = $nombres_nuevos;
        $_SESSION['apellidos'] = $apellidos_nuevos;
        $_SESSION['correo_institucional'] = $nuevo_correo;
        $_SESSION['fecha_nac'] = $nueva_fecha;

        $mensaje = "<div class='alert alert-success text-center fw-bold shadow-sm'>¡Datos institucionales actualizados con éxito!</div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>Error al actualizar: " . $conexion->error . "</div>";
    }
}

$nombres_real = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : '';
$apellidos_real = isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : '';
$correo_real = $_SESSION['correo_institucional'];
$fecha_real  = $_SESSION['fecha_nac'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Técnico - IPASB</title>
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
                        <a class="nav-link active fw-semibold mb-2" href="perfil.php" style="background-color: #003366;">
                            Mi Perfil / Editar Datos
                        </a>
                        <a class="nav-link text-secondary fw-semibold mb-2" href="cambiar_password.php">
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
                    <h2 class="h4 fw-bold mb-1">¡Bienvenido al Sistema Institucional!</h2>
                    <p class="mb-0 opacity-75 small">Desde este panel puede gestionar su información personal.</p>
                </div>

                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-dark mb-3">Actualizar Información Personal</h3>
                        <p class="text-muted small mb-4">Modifique los campos necesarios y presione guardar para actualizar su perfil de técnico.</p>
                        
                        <?php echo $mensaje; ?>
                        
                        <form action="perfil.php" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Cédula de Identidad (No modificable)</label>
                                <input type="text" class="form-control bg-body-secondary text-secondary" value="<?php echo $cedula_real; ?>" readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label fw-semibold">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $nombres_real; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos_real; ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label fw-semibold">Correo Electrónico Institucional</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo_real; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_real; ?>" required>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                                    Guardar Cambios
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