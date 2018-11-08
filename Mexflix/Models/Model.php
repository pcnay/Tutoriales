<?php
// Puede tener metodos abstractos, y solo se heredan en las clases hijas y es donde se definen.
// Permite la conexion a la base de datos.
// No se incrusta archivo de las demás capas.

abstract class Model
{
  // Definiendo los atributos
  // private static = Solo es accesible en esta clase solamente, estan protegidas.
  private static $db_host = 'localhost';
  private static $db_user = 'root';
  private static $db_pass = '';
  // Para indicar el nombre de la base de datos, se defienen en las clases hijas (donde se define el método en la sección de Constructor ), ya que cuando se tiene aplicaciones grandes se utilizan mas de una base de datos. No se puede utilizar de maneja pública.
  //protected $db_name = 'mexflix';
  private static $db_name = 'mexflix';
  // Permite establecer el juego de caracteres para el ideoma de Español.
  private static $db_charset = 'utf8';
  // Variable para guardar la conexión a MySQL
  private $conn;
  // Donde se guardaran las consultas a ejecutar
  protected $query;
  // Donde se guardaran las consultas
  protected $rows = array();

  // Por lo general los programadores hacen uso extenso de consultas a la Base de datos. Con solo una sola vez es suficiente ya que se guarda en un Arreglo Asociativo antes definied ($rows)

  // Definiendo los métodos
  // Abstracto para el CRUD de clases que hereden
  // Se definen en otra clase que es heredada.
  // Se modifican las dos funciones "create" y "update" por la  función "replace" ya que esta contiene un comando que realiza las dos tareas de Insertar y Actualizar.
  /*
  abstract protected function create();
  abstract protected function read();
  abstract protected function delete();
  abstract protected function update();
  */

  abstract protected function set(); // Establecer un valor, si existe Actualiza, sino Agrega.
  abstract protected function get(); // Para leer registros
  abstract protected function del(); // Borrar los registros.


  // Método privado para conectarse en de la base de datos.
  //mysqli = Tiene dos formas de conectarse : Orientada a Objetos y Escrutural:
  // http://php.net/manual/es/mysqli.quickstart.dual-interface.php

  private function db_open()
  {
    // self:: = Operador de resolución de ambito.
    //$this->conn = new mysqli($this->$db_host);
    $this->conn = new mysqli(
      self::$db_host,
      self::$db_user,
      self::$db_pass,
      self::$db_name);

      $this->conn->set_charset(self::$db_charset);
       
  }
  // Método privado para desconectarse en de la base de datos.
  private function db_close()
  {
    $this->conn->close();
  }

  // Establecer un query que afecte datos (INSERT, DELETE, UPDATE )
  // afectan a los datos.
  protected function set_query()
  {
    $this->db_open();
    //$this->conn->query() = Es un método de la clase "mysqli" 
    $this->conn->query($this->query);
    $this->db_close();
  }
  
  // Obtener resultados de un Query.
  protected function get_query()
  {
    $this->db_open();
    //$this->conn->query() = Es un método de la clase "mysqli" 
    $result = $this->conn->query($this->query);

    // No tiene cuerpo
    // fetch_assoc = Convierte los obtenido de la consulta en arreglo asociativo (Clave , Valor)
    // Obtiene el valor de un registro de la tabla por nombre de campo, es decir cuando se escribe "nombre" nos muestra el contenido.
    //http://php.net/manual/es/mysqli-result.fetch-assoc.php
    // Cada una de las posiciones de "rows" va guardando cada registro de la consulta 
    while ($this->rows[] = $result->fetch_assoc() );
    $result->close(); // Cierra la consulta y limpiarnos la memoria

    $this->db_close();    

    // array_pop =  se utiliza para suprimir el último valor del arreglo, ya que siempre es NULL.
    // http://php.net/manual/es/function.array-pop.php
    return array_pop($this->rows);
  }
 
}

?>
