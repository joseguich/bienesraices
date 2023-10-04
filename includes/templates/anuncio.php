<?php
require __DIR__ . '/../config/database.php';

//Importar la intancia de la base de datoa.
$db = conectarDB();

//Consultar la base de datos.
$query = "SELECT * FROM propiedades LIMIT {$limite}";

//Obtener Resultado
$tablaPropiedades = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">
   <?php while ($propiedades = mysqli_fetch_assoc($tablaPropiedades)) : ?>
      <div class="anuncio">
         <img src="/imagenes/<?php echo $propiedades['imagen']; ?>" loading="lazy" alt="anuncio">
         <div class="contenido-anuncio">
            <h3><?php echo $propiedades['titulo']; ?></h3>
            <p><?php echo $propiedades['descripcion']; ?></p>
            <p class="precio">DOP$ <?php echo $propiedades['precio']; ?></p>

            <ul class="iconos-caracteristicas">
               <li>
                  <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                  <p><?php echo $propiedades['wc']; ?></p>
               </li>
               <li>
                  <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                  <p><?php echo $propiedades['estacionamiento']; ?></p>
               </li>
               <li>
                  <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                  <p><?php echo $propiedades['habitaciones']; ?></p>
               </li>
            </ul>

            <a href="anuncio.php?id=<?php echo $propiedades['id']; ?>" class="boton-amarillo-block">
               Ver Propiedad
            </a>
         </div>
         <!--.contenido-anuncio-->
      </div>
      <!--anuncio-->
   <?php endwhile; ?>

</div>
<!--.contenedor-anuncios-->

<?php
//Cerrar la conexión.
mysqli_close($db);
?>