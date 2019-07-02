<?php

	class ViewController
	{	
		// Esta clase carga todas las vistas de la aplicación, se manda como parámetro el nombre de la vista.	
		private static $view_path= './Views/';
	
		public function load_view($view)
		{
			// require_once($self::$view_path.$view.'.php');
			// Se agregan los archivos de Encabezados, la vista requerida y el pié de página.
			require_once(self::$view_path.'header.php');			
			require_once(self::$view_path.$view.'.php');
			require_once(self::$view_path.'footer.php');
		}

		public function __destruct()
		{
			//unset($this);
		}

	}
	
?>
