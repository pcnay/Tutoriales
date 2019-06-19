<?php
// Se utilizara clase Abstracta
abstract class Model
{
	// Se definen los atributos
	// private = Es protegido no es accesado aun cuando se herede.
	private static $db_host = 'localhost';//'localhost';
	private static $db_user = 'root';
	private static $db_pass = 'pcnay2003';
	// protected = Solo se utiliza en la clase hija, es decir cuando se hereda, mas no de forma pública
	// protected $db_name = 'ordenservicios';
	private static $db_name = 'ordenservicios'; // Se define en el constructor de la clase que se cree.
	private static $db_charset = 'utf-8'; // Para los caracteres de español.
	private $conn; // Solo es accesado por esta clase solamente.
	protected  $query;
	protected $rows = array(); // Se utilizaran los arreglos asociativos para las consultas que se realizen.

	// Definición de métodos
	// Métodos abstractos para CRUD de clases que hereden
	// se tiene que definir en las clases que se hereden.
	//abstract protected function create();
	//abstract protected function read();
	//abstract protected function update();
	//abstract protected function delete();
	// Se haran modificaciones a estas funciones, el motivo es por la instrucción "REPLACE"
	abstract protected function set();
	abstract protected function get();
	abstract protected function del();


	// Método privado para conectarse a la base de datos, por esta razón es "private"
	private function db_open()
	{
		//$this->$db_host
		// Manual del comando mysqli :
		// https://www.php.net/manual/es/book.mysqli.php
		
		// De esta forma de generar el objeto mysqli funciona para servidor remoto 
		$this->conn = new mysqli('localhost','root','pcnay2003','ordenservicios');

		// Esta funciona para manera de servidor mysql "local" - XAMMP
		//	$this->$db_host,// self::$db_host,	
		//	$this->$db_user,
		//	$this->$db_pass,
		//	$this->$db_name
		// );

		//$mysql = new mysqli('localhost','root','pcnay2003','ordenservicios');
		/*
		if ($mysql->connect_errno) 
		{
			echo "Fallo al conectar a MySQL: (" . $mysql->connect_errno . ") " . $mysql->connect_error;
		}
		echo $mysql->host_info . "\n";
		*/
	
		// Permite establecer el juego de caracteres a la base de datos. teclado Español.
		$this->conn->set_charset(self::$db_charset);
	}
	private function db_close()
	{
		$this->conn->close();
	}

	// Establecer un query simple del tipo INSERT, DELECTE, UPDATE para traer los resultados de una consulta en un arreglo 
	// protected = Es accedido desde las clase heredadas.
	protected function set_query()
	{
		$this->db_open();
		// ->query es un método de la clase "mysqli"
		// $this->query = Esta es asignado por la clase heredada , es decir cuando se teclea la consulta a realizar.
		$this->conn->query($this->query);
		$this->db_close();
	}

	// traer resultados de una consulta de tipo SELECT de un arreglo.
	protected function get_query()
	{
		$this->db_open();
		
		//echo 'Abrio conexion Base De Datosw';
		$result = $this->conn->query($this->query);
		// En este arreglo se grabaran los valores de la consulta, esta sera de forma asociativa "Clave , Valor" por la instrucción "fetch_assoc"
		// "fetch_assoc" = Retorna los registros de una consulta por los nombres de campos
		// https://www.php.net/manual/es/mysqli-result.fetch-assoc.php
		while ( $this->rows[] = $result->fetch_assoc() );
		
		$result->close(); // Cierra la consulta y libera memoria.
		$this->db_close(); // Cerrar la conexión.

		return array_pop($this->rows);
	}
}

?>
