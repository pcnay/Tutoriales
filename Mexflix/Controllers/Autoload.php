<?php
	// Se agrego para probar configuracion.
	//
	// Se agrega otra linea para pruebas.
	
  // Con este archivo se evita utilzar el "require" en cada una de las clase que utiliza el programa
  class Autoload
  {
    public function __construct()
    {
      // spl_autoload_register = Puede recibir una función como parámetro  

      spl_autoload_register(function($class_name){
        // Se debe indicar las rutas.
        // Cargara todas las clases que se encuentren en este directorio.
        // Cada vez que se instancia una clase, se agregan todos los archivos que requiere de la carpeta .
        
        $models_path = './models/'.$class_name.'.php';
        $controllers_path = './controllers/'.$class_name.'.php';
        
        /* 
        echo "<p>$models_path</p>
        <p>$controllers_path</p>      
        ";
        */ 
        
        // include = Error pero continua la ejecución
        // require = Error y no contunua la ejecución
        if (file_exists($models_path))
        {
          require_once($models_path);
        }
        if (file_exists($controllers_path))
        {
          require_once($controllers_path);
        }

      } );


    }

    public function __destruct()
    {
      // unset($this);
    }
  }
?>