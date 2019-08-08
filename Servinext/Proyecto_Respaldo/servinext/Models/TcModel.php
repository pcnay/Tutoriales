<?php
	// Antes este archivo se encontraba en la carpeta de "tc", ahora estan en el mismo nivel
	// require_once('./Models/Model.php');
	// require_once('Model.php'); Se comenta por la funcion "AutoLoad()"
	class TcModel extends Model
	{
		//public $id_tipo_componente;
		//public $descripcion;

		public function __construct()
		{
			// Si se conectaran a mas de una base de datos, es aqui donde se define.
			$this->db_name = 'ordenservicios';			
		}

		public function __destruct()
		{
			//unset($this);
		}

		// Recibe un arreglo la funcion.
		//public function create($tc_datos=array() )		
		public function set($tc_datos=array() )		
		{
			foreach ($tc_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "REPLACE INTO t_Tipo_Componente (id_tipo_componente,descripcion) VALUES ($id_tipo_componente,'$descripcion')";
			// Insertando el valor nuevo.
			$this->set_query(); 
		}
		// Si "$id_tipo_componente" esta vacio, le asigna espacio en blanco
		public function get($id_tipo_componente='')
		{				
			// Se coloca en comillas para que tome el valor de la variable "$id_tipo_componente"
			$this->query = ($id_tipo_componente != '')
			?"SELECT * FROM t_Tipo_Componente WHERE id_tipo_componente = $id_tipo_componente"
			:"SELECT * FROM t_Tipo_Componente";
			
			/*
				if ($id_tipo_componente != '')
				{
					$sql = "SELECT * FROM t_Tipo_Componente WHERE id_tipo_componente = $id_tipo_componente";
				}
				else
				{
					$sql = "SELECT * FROM t_Tipo_Componente";
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

	public function update($tc_datos=array())
		{
			foreach ($tc_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "UPDATE t_Tipo_Componente SET id_tipo_componente = $id_tipo_componente,descripcion = '$descripcion' WHERE id_tipo_componente = $id_tipo_componente";
			
			$this->set_query(); 

		}
	*/

		// Si no se manda parámetro, le asigna en blanco
		public function del($id_tipo_componente='')
		{
			$this->query= "DELETE FROM t_Tipo_Componente WHERE id_tipo_componente = $id_tipo_componente";
			$this->set_query();
		}

	}
?>