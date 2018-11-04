<?php
  require_once('Model.php');

  // ORM es mapear una tabla de la base de datos para despues utilizarla como objeto.
  
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
   public function create()
   {

   }
   //si no se manda valor alguno, se asigna espacio en blanco
   public function read($buscar_articulo_id = '')
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
   public function update()
   {

   }
   public function delete()
   {

   }

  }
?>"