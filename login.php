<?php
//Iniciar Sesión
require 'includes/config/database.php';
$db = conectarDB();

$errores = [];
$entrada = false;

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
      //Revisar si el usuario existe.
      $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
      $tableUsuarios = mysqli_query($db, $query);

      //Ver si un usuario existe o comprobar si hay una existe una consulta en la base de datos.
      if ($tableUsuarios->num_rows) {
         //Revisar que el password es correcto.
         $usuarios = mysqli_fetch_assoc($tableUsuarios);

         //Verificar si el password es correcto o no 
         $autenticado = password_verify($password, $usuarios['password']);
         if ($autenticado) {
            //El usuario esta autenticado.
            session_start();

            //Llenar el arreglo de la  Sesión
            $_SESSION['usuarios'] = $usuarios['email'];
            $_SESSION['login'] = true;
            header('Location: /admin');
         } else {
            $errores[] = 'El password es incorrecto';
         }
      } else {
         $errores[] = "El usuario no existe";
      }
   }
}

//Incluir el header
require 'includes/funciones.php';
incluirTemplate('header', $inicio = false);
?>

<main class='contenedor seccion contenido-centrado'>
   <h1>Iniciar Sesión</h1>
   <?php foreach ($errores as $error) : ?>
   <p class="alerta error"><?php echo $error ?></p>
   <?php endforeach; ?>
   <form method="POST" class="formulario">
      <fieldset>
         <legend>Email y Password</legend>

         <label for='email'>E-mail</label>
         <input type='email' placeholder='Tu Email' id='email' name="email">

         <label for='password'>Password</label>
         <input type='password' placeholder='Tu Password' id='password' name="password">
      </fieldset>

      <div class="direccionar">
         <input type="submit" value="Iniciar Sesión" class="boton boton-azul">
         <a href="usuario.php" class="boton boton-rojo">Registrarse</a>
         <a href="olvidar.php" class="boton boton-rojo">¿Olvidaste tu contraseña?</a>
      </div>
   </form>
</main>

<?php
incluirTemplate(
   'footer'
)
?>