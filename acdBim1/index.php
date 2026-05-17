<?php
session_start();

include("conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tecnicos WHERE correo = '$correo'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario_datos = $resultado->fetch_assoc();

        if (password_verify($password, $usuario_datos['password'])) {
            
            $_SESSION['id_tecnico'] = $usuario_datos['cedula'];
            $_SESSION['nombres'] = $usuario_datos['nombres'];
            $_SESSION['apellidos'] = $usuario_datos['apellidos'];
            $_SESSION['correo_institucional'] = $usuario_datos['correo'];
            $_SESSION['fecha_nac'] = $usuario_datos['fecha_nacimiento'];

            header("Location: perfil.php");
            exit();

        } else {
            $mensaje = "<div class='alert alert-danger text-center fw-bold'>Contraseña incorrecta. Verifique sus credenciales.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger text-center fw-bold'>El correo electrónico no está registrado.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IPASB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="w-100 bg-white shadow-sm text-center">
        <img src="imgs/logoIpasb.png" class="img-fluid" alt="Logo de IPASB" style="max-height: 300px; width: 100%; object-fit: cover;">
    </div>

    <div class="container my-5">
        <div class="row align-items-top g-5">
            
            <div class="col-md-6 text-black" style="text-align: justify; line-height: 2;">
                <p>
                    El INSTITUTO PROVINCIAL DE ASISTENCIA SOCIAL DE BOLIVAR IPAS-B, fue creado mediante Ordenanza Provincial con fecha 29 de enero de 2015, y es una institución que tiene por objeto la gestión de políticas sociales del Gobierno Autónomo Descentralizado de la Provincia de Bolívar (GADP-B), mediante la prestación de servicios públicos correspondientes y otros que se le encargue o deleguen conforme a su ámbito de acción y fines.
                    Entre los objetivos del IPAS-B, se encuentra brindar servicios públicos y actividades que gestione: salud, capacitación, programas y proyectos especiales y aquellos que designe el GADP-B, a través de instrumentos de planificación y presupuesto para la ejecución de políticas sociales.
                    Entre los fines institucionales, el INSTITUTO PROVINCIAL DE ASISTENCIA SOCIAL DE BOLIVAR en su literal d) y e), menciona el desarrollo de proyectos sociales con el propósito de coadyuvar el mejoramiento de la calidad de vida en las áreas de seguridad alimentaria y nutricional, desarrollo infantil y atención a la mujer y las personas de la tercera edad; y la protección de grupos vulnerables de la población.
                </p>
            </div>

            <div class="col-md-6 d-flex justify-content-center">
                <div class="card shadow p-4" style="max-width: 460px; width: 100%; border-radius: 12px;">
                    
                    <div class="text-center border-bottom pb-3 mb-4">
                        <h1 class="h4 text-success fw-bold mb-2">PREFECTURA DE BOLÍVAR</h1>
                        <h2 class="h6 text-danger fw-semibold mb-2">Instituto Provincial de Asistencia Social de Bolívar</h2>
                        <h3 class="h6 text-secondary fw-bold mb-2">Sistema de Gestión para Técnicos de Territorio</h3>
                    </div>

                    <?php echo $mensaje; ?>
                    
                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label for="correo" class="form-label fw-semibold text-dark">Correo Electrónico Institucional</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@bolivar.gob.ec" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-dark">Contraseña de Acceso</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 mt-2"; border: none;>
                            Ingresar al Sistema
                        </button>
                    </form>

                    <div class="text-center mt-4 small text-muted">
                        ¿Eres un técnico nuevo? <a href="registro.php" class="text-danger fw-bold text-decoration-none">Regístrate aquí</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>