 <?php
	/* Carga todo los archivos que va requiriendo la aplicación.
		 Registra las funciones dadas como implementación . 
		 Todos los archivos que encuentra en la carpeta definada los va a cargar en memoria de la computadora.
	*/
	class AutoLoad
	{	
		public function __construct()
		{			
			//https://www.php.net/manual/en/function.spl-autoload-register.php

			spl_autoload_register(function($class_name)
			{
				$models_path = './Models/'.$class_name.'.php';
				$controllers_path = './Controllers/'.$class_name.'.php';
				
				// Desplegará el nombre de las carpetas en pantalla, se tiene que incluir el nomnbre de la rutas.
				//echo "<p>$models_path</p>";
				//echo "<p>$controllers_path</p>";
				// La diferencia de "requiere" e "include", es que "include" permite la ejecución del programa y "requiere" realiza lo contrario.

				// Se tiene que validar que exista el archivo antes de lo que llame. Todos los que encuentre en la carpeta de Models y Controllers. 
				if (file_exists($models_path))
				{
					require_once($models_path);
					//echo "<p>$models_path</p>";
				}
				
				if (file_exists($controllers_path))
				{
					require_once($controllers_path);	
					//echo "<p>$controllers_path</p>";
				}
		

			});
			
		}

		public function __destruct()
		{
			//unset($this);
		}
	}
 ?>
