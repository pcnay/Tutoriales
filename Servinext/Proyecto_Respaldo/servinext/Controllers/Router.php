<?php
	class Router
	{
		public $route;
		public function __construct($route)
		{
			if (!isset($_SESSION))
			{
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

			if (!isset($_SESSION['ok']))
			{
				$_SESSION['ok'] = false; 
			}
			// Controla el flujo de la aplicación
			if($_SESSION['ok'])
			{
				// Toda la programación de la aplicación.
			}
			else
			{
				//Mostrar un formulario de Autenticación.
				// Se utilizaran controladores para las vistas
				$login_form = new ViewController();
				$login_form->load_view('login');
			}
		}
		public function __destruct()
		{
			//unset($this);
		}
	}
?>