<?php
require 'includes/funciones.php';
require 'includes/config/database.php';

$db = conectarDB();

$error;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = $_POST['email'];
   $newPassword = $_POST['new_password'];

   // Realiza la validación de los campos


   // Paso 1: Verificar si el correo existe en la base de datos

   if ($db->connect_error) {
      die('Error de conexión a la base de datos: ' . $db->connect_error);
   }

   $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
   $resultado = $db->query($query);


   if (!$email || !$newPassword) {
      $error = 'Debes ingresar un correo y una contraseña';
   } else if ($resultado->num_rows === 0) {
      // El correo no existe en la base de datos
      $error = "El correo proporcionado no está registrado en nuestra base de datos.";
   } else  if (strlen($newPassword) < 6) {
      $error = "La nueva contraseña debe tener al menos 6 caracteres";
   } else {
      // Paso 2: Generar el hash de la nueva contraseña
      $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

      // Paso 3: Actualizar el hash de la contraseña en la base de datos
      $updateQuery = "UPDATE usuarios SET password = '{$hashedNewPassword}' WHERE email = '{$email}'";

      if ($db->query($updateQuery) === TRUE) {
         // Contraseña actualizada con éxito
         header('Location: login.php'); // Redirige al usuario a la página de inicio de sesión
         exit;
      } else {
         $error = "Hubo un problema al cambiar la contraseña: " . $db->error;
      }
   }

   $db->close();
}

incluirTemplate('header');
?>
<main class="contenedor seccion contenido-centrado">
   <h1>Recuperar Contraseña</h1>
   <?php if (isset($error)) { ?>
      <p class="alerta error "><?php echo $error; ?></p>
   <?php } ?>
   <form method="POST" class="formulario">
      <fieldset>
         <legend>Email y Password</legend>

         <label for="email">E-mail</label>
         <input type="email" placeholder="Ingresa tu correo para registrarte" id="email" name="email">

         <label for="new_password">Nuevo Password</label>
         <input type="password" placeholder="Tu Nuevo Password" id="new_password" name="new_password">
      </fieldset>

      <div class="direccionar">
         <input type="submit" value="Cambiar contraseña" class="boton boton-azul">
         <a href="login.php" class="boton boton-rojo">Iniciar Sesión</a>
      </div>
   </form>
</main>

<?php
incluirTemplate('footer');
?>