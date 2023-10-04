<?php
//este es el archivo actual app.php
function conectarDB(): mysqli
{
   $db = mysqli_connect('localhost', 'root', '', 'bienesraices_crud');

   if (!$db) {
      echo "Error la base de dato no esta conectada.";
      exit;
   }

   return $db;
}
