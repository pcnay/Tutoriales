<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar las archivos que requiera cada modulo que se utilize en el sisteme de MexFlix.

  // require_once('Model.php');

  // ORM es mapear una tabla de la base de datos para despues utilizarla como objeto.
  // Esta clase no tiene relación con la capa +Model+ en lo referente a la conexión de la base de datos, ya que solo accesa a un método de la clase +Model+
    
  class ArticuloModel extends Model
  {
    // Campos de la tabla de "Estatus", se definen como atributos en esta clase.
    public $articulo_id;
    public $descripcion;
    public $marca;
    public $modelo;
    public $num_serial;
    public $num_parte;
    public $existencia;

    public function __construct()
    {
      $this->db_name = 'ctrlfolios';
    }

    public function __destruct()
    {
      //unset($this);
    }

    // Se tiene que definir los métodos abstractos de la clase Padre que se definio.
   public function set($articulo_dato=array())
   {
    
    foreach ($articulo_dato as $nombreCampo => $contenidoCampo)
    {
      // Para convertir de valor arreglo a variable, se le llama Variable a Variable
      // $key = Exrae el nombre de la posición asociativa.
      // $$key = Esta posición la convierte a una variable de PHP.
      // http://php.net/manual/es/language.variables.variable.php
      $$nombreCampo = $contenidoCampo;
    }
    

    $this->query = "REPLACE INTO articulos (articulo_id,descripcion,marca,modelo,num_serial,num_parte,existencia) VALUES ($articulo_id,'$descripcion','$marca','$modelo','$num_serial','$num_parte',$existencia)";
    $this->set_query();

   }
   //si no se manda valor alguno, se asigna espacio en blanco
   public function get($buscar_articulo_id = '')
   { 
    // se manajen dos formas para obtener los datos:
      // Se coloca "" para que tome el valor de la variable "$buscar_articulo_id"
      // Este "$sql" es un atributo de la clase "Model" 
      
      /*
        Lo mismo del anterior:
        if ($buscar_articulo_id != '' )
        {
          $sql = "SELECT * FROM articulo WHERE articulo_id = $buscar_articulo_id";
        }
        else
        {
          $sql = "SELECT * FROM articulo";
        }
      */
      $this->query = ($buscar_articulo_id != '' )?"SELECT * FROM articulos WHERE articulo_id = $buscar_articulo_id":"SELECT * FROM articulos";
      
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
   /*
   public function update($actualizar_articulo=array())
   {
    foreach ($actualizar_articulo as $nombreCampo => $contenidoCampo)
    {
      $$nombreCampo = $contenidoCampo;
    }

    // El valor de la variable $estatus_id, $estatus, se original del ciclo anterior.
    $this->query = "UPDATE articulos SET articulo_id = $articulo_id ,
                            descripcion = '$descripcion',
                            marca = '$marca',
                            num_serial = '$num_serial',
                            num_parte = '$num_parte',
                            existencia = $existencia
                             WHERE articulo_id = $articulo_id";

    $this->set_query();

   }
   */ 

   public function del($articulo_id = '')
   {
    $this->query = "DELETE FROM articulos WHERE articulo_id = $articulo_id";
    $this->set_query();

   }

  }
?>