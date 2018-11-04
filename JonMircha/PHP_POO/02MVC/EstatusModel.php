<?php
  require_once('Model.php');

  // ORM es mapear una tabla de la base de datos para despues utilizarla como objeto.
  
  class EstatusModel extends Model
  {
    // Campos de la tabla de "Estatus", se definen como atributos en esta clase.
    public $estatus_id;
    public $estatus;
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
   public function create($estatus_data = array())
   {
     foreach ($estatus_data as $nombreCampo => $contenidoCampo)
      {
        // Para convertir de valor arreglo a variable, se le llama Variable a Variable
        // $key = Exrae el nombre de la posición asociativa.
        // $$key = Esta posición la convierte a una variable de PHP.
        // http://php.net/manual/es/language.variables.variable.php
        $$nombreCampo = $contenidoCampo;
      }

      $this->query = "INSERT INTO estatus (estatus_id,estatus) VALUES ($estatus_id,'$estatus')";
      $this->set_query();
   }
   //si no se manda valor alguno, se asigna espacio en blanco
   public function read($buscar_estatus_id = '')
   { 
    // se manajen dos formas para obtener los datos:
      // Se coloca "" para que tome el valor de la variable "$buscar_estatus_id"
      // Este "$sql" es un atributo de la clase "Model" 
      
      /*
        Lo mismo del anterior:
        if ($estatus_id != '' )
        {
          $sql = "SELECT * FROM estatus WHERE estatus_id = $buscar_estatus_id";
        }
        else
        {
          $sql = "SELECT * FROM estatus";
        }
      */
      $this->query = ($buscar_estatus_id != '' )?"SELECT * FROM estatus WHERE estatus_id = $buscar_estatus_id":"SELECT * FROM estatus";
      
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

   public function delete($estatus_id = '')
   {
      $this->query = "DELETE FROM estatus WHERE estatus_id = $estatus_id";
      $this->set_query();
   }

  }
?>"