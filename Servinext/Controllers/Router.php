<?php
  // Se definen las rutas que se tendrán en la aplicación.
  class Router
  {
    // $route = El valor proviene del archivo "index.php"
    public $route;
    public function __construct($route)
    {
      // Determinara primero si existe la sesion o no.
      // Cuando inicia por primera vez crea la sesion.
      if ( !isset($_SESSION) )
      {
        // http://php.net/manual/es/function.session-start.php    
        // Revisar el archivo de configuracion "PHP.INI", en XAMPP.
        // se agrega un arreglo como parametro en la PHP 7, modifican en PHP.ini
        // Valores minímos para que opera la sesión en PHP 7
        
        session_start([
          "use_only_cookies" => 1,
          //x Este valor es solo modificable en ".htaccess, httpd.conf,user.ini
          // No tine sentido en tiempo de ejecución decirle a PHP que autinicie sesion
          // a la vez que inicias session.
          "auto_start", // <=======
          "read_and_close" => false // La sesion se cierre automaticamente.
                                    // Si se coloca a "true" no funciona la variable Global 
                                    // $_SESSION['ok'],


          /* Valores originales, pero no funciona en PHP Ver 7 
          "use_only_cookies" => 1,
          "auto_start" => 1,
          "read_and_close" => true
          */

        ]);
        $_SESSION['ok'] = false;

      }

      // cuando se crea la sesion se asignara a la variable sesion "ok" el valor de true
      if ($_SESSION['ok']==true)
      {
        // Abarcara toda la programación perminente de la aplicación
      }
      else
      {
        // Se desplegará un formulario de autenticación.

      }

    }
    public function __destroy()
    {
      //unset($this);
    }


  }
?>
