<?php
	// Antes este archivo se encontraba en la carpeta de "Modelos", ahora estan en el mismo nivel
	// require_once('./Models/Model.php');
	// require_once('Model.php'); Se comenta por la funcion "AutoLoad()"
	class ModelosModel extends Model
	{
		//public $id_modelo;
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
		//public function create($modelos_datos=array() )		
		public function set($modelos_datos=array() )		
		{
			foreach ($modelos_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "REPLACE INTO t_Modelo (id_modelo,descripcion) VALUES ($id_modelo,'$descripcion')";
			// Insertando el valor nuevo.
			$this->set_query(); 
		}
		// Si "$id_modelos" esta vacio, le asigna espacio en blanco
		public function get($id_modelos='')
		{				
			// Se coloca en comillas para que tome el valor de la variable "$id_modelos"
			$this->query = ($id_modelos != '')
			?"SELECT * FROM t_Modelo WHERE id_modelo = $id_modelos"
			:"SELECT * FROM t_Modelo";
			
			/*
				if ($id_modelo != '')
				{
					$sql = "SELECT * FROM t_Modelo WHERE id_modelo = $id_modelo";
				}
				else
				{
					$sql = "SELECT * FROM t_Modelo";
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

	public function update($modelos_datos=array())
		{
			foreach ($modelos_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "UPDATE t_Modelo SET id_modelo = $id_modelo,descripcion = '$descripcion' WHERE id_modelo = $id_modelo";
			
			$this->set_query(); 

		}
	*/

		// Si no se manda parámetro, le asigna en blanco
		public function del($id_modelo='')
		{
			$this->query= "DELETE FROM t_Modelo WHERE id_modelo = $id_modelo";
			$this->set_query();
		}

	}
?>