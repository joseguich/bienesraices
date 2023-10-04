<?php
require 'app.php';

function incluirTemplate(string $nombre, bool $inicio = false)
{
   //Mostrar las funciones de templete por funciones para recortar el código.
   include TEMPLATES_URL . "/{$nombre}.php"; //Mostrar la URL de Templates.
}

function estaAutenticado(): bool
{
   session_start();

   $auth = $_SESSION['login'];
   if ($auth) {
      return true;
   }
   return false;
}

function sesion(bool $entrada)
{
   return $entrada === true;
}
