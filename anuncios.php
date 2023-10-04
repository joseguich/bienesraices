<?php

declare(strict_types=1);

require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">

   <h2>Casas y Depas en Venta</h2>


   <?php
   $limite = 50;
   include 'includes/templates/anuncio.php'

   ?>
</main>

</body>

</html>
<?php
incluirTemplate('footer');
?>