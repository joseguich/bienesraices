<?php
// Importar la conexión de la base de datos
require 'includes/config/database.php';
$db = conectarDB();

$errores = [];

//Autenticar el usuario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   //Datos sanitisado para enviar a la base de datos y validar que sea un email valido
   $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
   $password = mysqli_real_escape_string($db, $_POST['password']);

   if (!$email) {
      $errores[] = 'El email es obligatorio o no es válido';
   }

   if (!$password) {
      $errores[] = 'El password es obligatorio.';
   } else   if (strlen($password) < 6) {
      $errores[] = 'Password debe contener más de 6 carecteres';
   }

   if (empty($errores)) {

      $consultar = "SELECT * FROM usuarios WHERE email = '$email'";
      $resultado = mysqli_query($db, $consultar);

      if ($resultado->num_rows > 0) {
         $errores[] = "Este correo ya está registrado. Por favor, inicia sesión en lugar de registrarte nuevamente.";
         var_dump($errores);
         exit;
      } else {
         //Hashear Passwords.
         $passwordHash =  password_hash($password, PASSWORD_DEFAULT);

         //Query para crear el usuario.
         $query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}');";

         //Agregarlo a la base de datos.
         mysqli_query($db, $query);
      }

      header("Location: /login.php ");
   }
}
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class='contenedor seccion contenido-centrado'>
   <h1>Registrarte</h1>
   <?php foreach ($errores as $error) : ?>
      <p class="alerta error"><?php echo $error ?></p>
   <?php endforeach; ?>
   <form method="POST" class="formulario">
      <fieldset>
         <legend>Email y Password</legend>

         <label for='email'>E-mail</label>
         <input type='email' placeholder='Ingresa tu correo para registrare' id='email' name="email">

         <label for='password'>Password</label>
         <input type='password' placeholder='Tu Password' id='password' name="password">
      </fieldset>



      <div class="direccionar">
         <input type="submit" value="Registrarte" class=" boton boton-azul">
         <a href="login.php" class="boton boton-rojo">Iniciar Sesión</a>
      </div>
   </form>
</main>

<?php
incluirTemplate(
   'footer'
)
?>