<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar los archivos que requiera cada modulo que se utilize en el sisteme de Control De Folios
  
  // require_once('Model.php');

  // ORM es mapear una tabla de la base de datos para despues utilizarla como objeto.
  // Esta clase no tiene relación con la capa +Model+ en lo referente a la conexión de la base de datos, ya que solo accesa a un método de la clase +Model+
  class UsersModel extends Model
  {
    // Se tiene que indicar en el constructor en cada clase que se cree a cual base de datos se conectara.
    public function __construct()
    {
      $this->db_name = 'ctrlfolios';
    }

    public function __destruct()
    {
      //unset($this);
    }

    // Se tiene que definir los métodos abstractos de la clase Padre que se definio.
    // Recibe un arreglo.
   //public function create($estatus_data = array())
   public function set($user_data = array())
   {
     foreach ($user_data as $nombreCampo => $contenidoCampo)
      {
        // Para convertir de valor arreglo a variable, se le llama Variable a Variable
        // $key = Exrae el nombre de la posición asociativa.
        // $$key = Esta posición la convierte a una variable de PHP.
        // http://php.net/manual/es/language.variables.variable.php
        $$nombreCampo = $contenidoCampo;
      }

      $this->query = "REPLACE INTO users (user,email,names,birthday,pass,roles) VALUES ('$user','$email','$names','$birthday',MD5('$pass'),'$roles')";

      $this->set_query();
   }
   
   //si no se manda valor alguno, se asigna espacio en blanco
   public function get($buscar_user = '')
   { 
    // se manajen dos formas para obtener los datos:
      // Se coloca "" para que tome el valor de la variable "$buscar_user"
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
      $this->query = ($buscar_user != '' )?"SELECT * FROM users WHERE user = $buscar_user":"SELECT * FROM users";
      
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


   public function del($user_id = '')
   {
      $this->query = "DELETE FROM users WHERE user = '$user_id'";
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


   // Determina si existe el usuario.
   public function validate_user($user,$pass)
   {
     $this->query = "SELECT * FROM users WHERE user = '$user' AND pass = MD5('$pass')";
     $this->get_query();

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

  } // class UserModels    

?>
