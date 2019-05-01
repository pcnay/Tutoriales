<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar las archivos que requiera cada modulo que se utilize en el sisteme de MexFlix.
  
  // require_once('Model.php');

  // ORM es mapear una tabla de la base de datos para despues utilizarla como objeto.
  // Esta clase no tiene relación con la capa +Model+ en lo referente a la conexión de la base de datos, ya que solo accesa a un método de la clase +Model+
  class MovieSeriesModel extends Model
  {
    // Campos de la tabla de "MovieSeries", se definen como atributos en esta clase.
    // Se tiene que indicar en el constructor en cada clase que se cree a cual base de datos se conectara.
    public function __construct()
    {
      $this->db_name = 'mexflix';
    }

    public function __destruct()
    {
      //unset($this);
    }

    // Se tiene que definir los métodos abstractos de la clase Padre que se definio.
    // Recibe un arreglo.
	 //public function create($estatus_data = array())
	 // ms = movieSerie
   public function set($ms_data = array())
   {
     foreach ($ms_data as $nombreCampo => $contenidoCampo)
      {
        // Para convertir de valor arreglo a variable, se le llama Variable a Variable
        // $key = Extrae el nombre de la posición asociativa.
        // $$key = Esta posición la convierte a una variable de PHP.
        // http://php.net/manual/es/language.variables.variable.php
        $$nombreCampo = $contenidoCampo;
			}
			
			// Corrigiendo el problema de "\'s" de los textos ingles que lo manejan pero en la definicion del comando para grabar no lo realiza.
			$plott = str_replace("'","\'",$plott );

      $this->query = "REPLACE INTO movieseries SET imdb_id = '$imdb_id',title = '$title',plott='$plott',author='$author',actors='$actors',country='$country',premiere='$premiere',poster='$poster',trailer='$trailer',rating=$rating, genres='$genres',estatus=$estatus,category='$category'";

      $this->set_query();
   }


   
   //si no se manda valor alguno, se asigna espacio en blanco
   public function get($ms = '')
   { 
    // se manajen dos formas para obtener los datos:
      // Se coloca "" para que tome el valor de la variable "$ms"
      // Este "$sql" es un atributo de la clase "Model" 
      
      /*
        Lo mismo del anterior:
        if ($ms != '' )
        {
          $sql = "SELECT * FROM movieseries WHERE imdb_id = $ms";
        }
        else
        {
          $sql = "SELECT * FROM movieseries";
        }
      */
      $this->query = ($ms != '' )?
      "SELECT ms.imdb_id,ms.title,ms.plott,ms.author,ms.actors,ms.country,ms.premiere,ms.poster,ms.trailer,ms.rating,ms.genres,s.estatus,ms.category
        FROM movieseries AS ms INNER JOIN estatus AS s
        ON ms.estatus = s.estatus_id WHERE ms.imdb_id = '$ms'":
      "SELECT ms.imdb_id,ms.title,ms.plott,ms.author,ms.actors,ms.country,ms.premiere,ms.poster,ms.trailer,ms.rating,ms.genres,s.estatus,ms.category
        FROM movieseries AS ms INNER JOIN estatus AS s
        ON ms.estatus = s.estatus_id";
      
      $this->get_query();
      // Devuelve un arreglo de la consulta ejecutada.

      // convertir el contenido de un objeto en texto y poderlo mostrar en la pantalla.
      // var_dump($this->rows);
      // Ahora mostrar la información en la capa de Vista.
      // Obtener el número de elementos del arreglo.
      $num_rows = count($this->rows);
      // echo $num_rows;
      $datos = array();

      // Permite recorre un arreglo de una forma mas optimizada.
      //http://php.net/manual/es/control-structures.foreach.php
      foreach ($this->rows as $nombreCampo => $contenidoCampo)
      {
        // Agrega al final del arreglo una nueva posicion.
        array_push($datos,$contenidoCampo);
        // La otra forma:
        // $datos[$nombreCampo] = $contenidoCampo;

      }

      return $datos;
   }


   public function del($ms = '')
   {
      $this->query = "DELETE FROM movieseries WHERE imdb_id = '$ms'";
      $this->set_query();
   }

/*
   // Esta función no se requiere por la modificacion de "Create" que ahora es "Set"
   public function update($estatus_data = array())
   {
    foreach ($estatus_data as $nombreCampo => $contenidoCampo)
    {
      $$nombreCampo = $contenidoCampo;
    }

    // El valor de la variable $estatus_id, $estatus, se original del ciclo anterior.
    $this->query = "UPDATE estatus SET estatus_id = $estatus_id ,
                            estatus = '$estatus' WHERE estatus_id = $estatus_id";

    $this->set_query();
   }
   */


  } // class EstatusModel    

?>