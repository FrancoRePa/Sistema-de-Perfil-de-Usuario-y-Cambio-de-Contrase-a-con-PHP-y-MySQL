<?php
include("conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $fecha_nac = $_POST['fecha_nacimiento'];
    $password = $_POST['password'];

    $sql_verificar = "SELECT * FROM tecnicos WHERE cedula = '$cedula' OR correo = '$correo'";
    $resultado_verificar = $conexion->query($sql_verificar);

    if ($resultado_verificar->num_rows > 0) {
        $usuario_duplicado = $resultado_verificar->fetch_assoc();
        
        if ($usuario_duplicado['cedula'] === $cedula) {
            $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>Error: El número de cédula ya se encuentra registrado.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>Error: El correo ya se encuentra registrado.</div>";
        }
    } else {
        
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tecnicos (cedula, nombres, apellidos, correo, fecha_nacimiento, password) 
                VALUES ('$cedula', '$nombres', '$apellidos', '$correo', '$fecha_nac', '$password_encriptada')";

        if ($conexion->query($sql) === TRUE) {
            $mensaje = "<div class='alert alert-success text-center fw-bold shadow-sm'>¡Registro grabado con éxito! Ya puedes iniciar sesión.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center fw-bold shadow-sm'>Error al guardar: " . $conexion->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Técnicos - IPASB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="w-100 bg-white shadow-sm text-center">
        <img src="imgs/logoIpasb.png" class="img-fluid" alt="Logo de IPASB" style="max-height: 300px; width: 100%; object-fit: cover;">
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <div class="card shadow-lg border-0" style="border-radius: 15px;">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <h2 class="h4 fw-bold text-success">Registro de Nuevo Técnico</h2>
                            <p class="text-muted small">Complete todos los campos para su registro en el sistema IPASB</p>
                            <hr class="text-secondary opacity-25">
                        </div>

                        <?php echo $mensaje; ?>

                        <form action="registro.php" method="POST">
                            
                            <div class="mb-3">
                                <label for="cedula" class="form-label fw-semibold">Cédula de Identidad</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" maxlength="10" placeholder="Ej: 0250362415" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label fw-semibold">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Franco Jordano" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Remache Parreño" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label fw-semibold">Correo Institucional</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="usuario@bolivar.gob.ec" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Contraseña de Acceso</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm">
                                    Finalizar Registro de Técnico
                                </button>
                            </div>

                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-muted">
                                ¿Ya tienes una cuenta? <a href="index.php" class="text-danger fw-bold text-decoration-none">Inicia sesión aquí</a>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>