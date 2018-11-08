<?php
// ".htaccess" = Lo utiliza Apache para asignar permisos a los archivos que se tienen dentro de la aplicación.
// Para evitar el error de que no se ha definido la variable, se recurre al uso del operador Ternario.
// isset() = Para saber si esta definida una variable.
$route = isset($_GET['r'] ) ? $_GET['r']:'home' ;
$mexflix = new Router($route);


?>