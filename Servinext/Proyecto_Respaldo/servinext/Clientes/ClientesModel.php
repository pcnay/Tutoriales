<?php
	require_once('./Models/Model.php');
	class ClientesModel extends Model
	{
		public $id_clientes;
		public $nombre;

		public function __construct()
		{
			$this->db_name = 'ordenservicios';
			//echo 'Entro al constructor';
		}

		public function __destruct()
		{
			//unset($this);
		}

		public function create()
		{

		}
		// Si "$id_clientes" esta vacio, le asigna espacio en blanco
		public function read($id_clientes='')
		{	
			//echo 'entro al read';
			// Se coloca en comillas para que tome el valor de la variable "$id_clientes"
			$this->query = ($id_clientes != '')
			?"SELECT * FROM t_Clientes WHERE id_clientes = $id_clientes"
			:"SELECT * FROM t_Clientes";
			
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

		public function update()
		{

		}
		public function delete()
		{
			
		}

	}
?>