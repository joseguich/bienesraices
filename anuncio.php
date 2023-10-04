<?php

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
   header('Location: /');
}

require 'includes/funciones.php';
incluirTemplate('header');

require  'includes/config/database.php';

//Importar la intancia de la base de datoa.
$db = conectarDB();

//Consultar la base de datos.
$query = "SELECT * FROM propiedades WHERE id = {$id}";

//Obtener Resultado
$tablaPropiedades = mysqli_query($db, $query);

//Si el ID no existe en la base de datos readicionalo al admin
if ($tablaPropiedades->num_rows === 0) {
   header('Location: /');
}

$propiedades = mysqli_fetch_assoc($tablaPropiedades);

?>

<main class="contenedor seccion contenido-centrado">
   <h1><?php echo $propiedades['titulo'] ?></h1>

   <img loading="lazy" src="imagenes/<?php echo $propiedades['imagen'] ?>" alt="imagen de la propiedad">

   <div class="resumen-propiedad">
      <p class="precio">DOP $<?php echo $propiedades['precio'] ?></p>
      <ul class="iconos-caracteristicas">
         <li>
            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
            <p><?php echo $propiedades['wc'] ?></p>
         </li>
         <li>
            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
            <p><?php echo $propiedades['estacionamiento'] ?></p>
         </li>
         <li>
            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
            <p><?php echo $propiedades['habitaciones'] ?></p>
         </li>
      </ul>

      <p><?php echo $propiedades['descripcion'] ?></p>
   </div>
</main>

</body>

</html>
<?php
incluirTemplate('footer');
?>

//