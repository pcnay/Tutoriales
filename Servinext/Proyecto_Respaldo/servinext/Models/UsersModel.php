<?php
	// Antes este archivo se encontraba en la carpeta de "Clientes", ahora estan en el mismo nivel
	// require_once('./Models/Model.php');
	// require_once('Model.php'); Se comenta por la funcion "AutoLoad()"
	class UsersModel extends Model
	{
		public function __construct()
		{
			// Si se conectaran a mas de una base de datos, es aqui donde se define.
			$this->db_name = 'ordenservicios';
			//echo 'Entro al constructor';
		}

		public function __destruct()
		{
			//unset($this);
		}

		// Recibe un arreglo la funcion.
		//public function create($clientes_datos=array() )		
		public function set($user_data=array() )		
		{
			foreach ($user_data as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "REPLACE INTO t_Usuarios (usuario,email,nombre,cumpleanos,clave,perfil) VALUES ('$usuario','$email','$nombre','$cumpleanos',MD5('$clave'),'$perfil')";
			// Insertando el valor nuevo.
			$this->set_query(); 
		}
		// Si "$id_clientes" esta vacio, le asigna espacio en blanco
		public function get($user='')
		{	
			//echo 'entro al read';
			// Se coloca en comillas para que tome el valor de la variable "$id_clientes"
			$this->query = ($user != '')
			?"SELECT * FROM t_Usuarios WHERE usuario = '$user'"
			:"SELECT * FROM t_Usuarios";
			
			/*
				if ($id_clientes != '')
				{
					$sql = "SELECT * FROM t_Clientes WHERE id_clientes = $id_clientes";
				}
				else
				{
					$sql = "SELECT * FROM t_Clientes";
				}
			*/ 
			//Ejecuta la consulta y la retorna en un arreglo.
			$this->get_query();
			// var_dump() = Convertir a cadena de texto el contenido de un objeto
			//var_dump($this->rows);
			
			// Se agrega código para mostrar en pantalla en forma de tabla la información que se obtuvo.
			// Obteniendo el numero de elementos del arreglo
			$num_renglones = count($this->rows);
			$datos = array();
			// Permite recorrer el arreglo de una forma optimizada.
			// $this->rows = Es el arreglo a recorrer.
			//https://www.php.net/manual/es/control-structures.foreach.php
			// Arreglo Asociativo es "$this->rows"
			foreach ($this->rows as $Campo => $Valor)
			{
				// Agrega al final del arreglo el valor de la interacción
				array_push($datos,$Valor);
				//$datos[$Campo] = $Valor;
			}			
			
			return $datos;
		}

/* Se desactiva por la instrucción REPLACE (funcion set)

	public function update($clientes_datos=array())
		{
			foreach ($clientes_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "UPDATE t_Clientes SET id_clientes = $id_clientes,nombre = '$nombre' WHERE id_clientes = $id_clientes";
			
			$this->set_query(); 

		}
	*/

		// Si no se manda parámetro, le asigna en blanco
		public function del($user='')
		{
			$this->query= "DELETE FROM t_Usuarios WHERE usuario = '$user'";
			$this->set_query();
		}

		// Buscara el usuario en la tabla de "t_Usuario".
		public function validate_user($user,$pass)
		{
			
			$this->query = "SELECT * FROM t_Usuarios WHERE usuario = '$user' AND clave = MD5('$pass') ";
			$this->get_query();
			$datos = array();
			// Permite recorrer el arreglo de una forma optimizada.
			// $this->rows = Es el arreglo a recorrer.
			//https://www.php.net/manual/es/control-structures.foreach.php
			// Arreglo Asociativo es "$this->rows"
			foreach ($this->rows as $Campo => $Valor)
			{
				// Agrega al final del arreglo el valor de la interacción
				array_push($datos,$Valor);
				//$datos[$Campo] = $Valor;
			}			
			
			return $datos;

		}
	}
?>