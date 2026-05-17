# Sistema de Gestión para Técnicos de Territorio del IPASB

Este proyecto consiste en un sistema web seguro y dinámico desarrollado para el **Instituto Provincial de Asistencia Social de Bolívar (IPASB)** de la **Prefectura de Bolívar**. La aplicación permite el registro, autenticación y gestión de la información personal de los técnicos del instituto.


## Características Principales

* **Autenticación Segura (Módulo de Acceso):** Control de sesiones activas mediante PHP que restringe el acceso a páginas privadas a usuarios no autenticados.
* **Registro Blindado:** Formulario de registro con sistema de control de duplicados en tiempo real (evita la duplicación de números de cédula y correos institucionales).
* **Seguridad de Contraseñas:** Encriptación de claves de acceso en la base de datos utilizando el algoritmo de hash robusto `PASSWORD_DEFAULT` de PHP.
* **Doble Factor de Validación Visual:** Módulo de cambio de contraseña protegido por un token dinámico auto-generado por sesión (Captcha interno) para mitigar ataques automatizados.
* **Diseño Institucional y Adaptativo:** Interfaz gráfica limpia, moderna y responsiva construida con **Bootstrap 5**, utilizando la paleta de colores oficiales de la institución.


## Tecnologías Utilizadas

* **Backend:** PHP 8.x (Manejo de sesiones, lógica de negocio y validaciones de seguridad).
* **Base de Datos:** MySQL (Modelo relacional para el almacenamiento de técnicos).
* **Frontend:** HTML5, CSS3 y Bootstrap v5.3 (Maquetación y estilos responsivos).
* **Entorno de Servidor:** XAMPP (Apache Server).

## Instalación y Configuración Local
## 1. Requisitos Previos
- Tener instalado XAMPP (con PHP 7.4 o superior).
- Un gestor de bases de datos como phpMyAdmin.

## 2. Importación de la Base de Datos
1. Abra su panel de **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Cree una nueva base de datos llamada exactamente `tecnicos_ipasb`.
3. Seleccione la base de datos recién creada y vaya a la pestaña **Importar** (en el menú superior).
4. Clic en *Seleccionar archivo* y elija el archivo `.sql` que se adjunta en la entrega de este proyecto.
5. Desplace la página hacia abajo y dé clic en el botón **Importar** para cargar automáticamente toda la estructura y los datos de prueba.

## 3. Despliegue del Código
1. Copie la carpeta del proyecto (acdBim1) y péguela dentro del directorio htdocs de tu instalación de XAMPP: C:\xampp\htdocs\proyectos\acdBim1\
2. Abra el panel de control de XAMPP y encienda los módulos de Apache y MySQL.
3. Ingresa desde tu navegador web a la siguiente dirección:
http://localhost/proyectos/acdBim1/

## 4. Código en VS Code
1. Abra el directorio: C:\xampp\htdocs\proyectos\
2. Doble clic sobre la carpeta **acdBim1**
3. Doble clic sobre el archivo .php que necesite

## 5. Credenciales de prueba
- usuraio: pablo@bolivar.ec
- contraseña: 123456