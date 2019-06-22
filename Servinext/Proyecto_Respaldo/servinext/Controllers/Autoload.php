 <?php
	/* Carga todo los archivos que va requiriendo la aplicación.
		 Registra las funciones dadas como implementación . 
		 Todos los archivos que encuentra en la carpeta definada los va a cargar en memoria de la computadora.
	*/
	class AutoLoad
	{	
		public function __construct()
		{			
			spl_autoload_register(function($class_name)
			{
				$models_path = './Models/'.$class_name.'.php';
				$controllers_path = './Controllers/'.$class_name.'.php';
				
				echo "<p>$models_path</p>";
				echo "<p>$controllers_path</p>";
				
			});
			
		}

		public function __destruct()
		{
			//unset($this);
		}
	}
 ?>
