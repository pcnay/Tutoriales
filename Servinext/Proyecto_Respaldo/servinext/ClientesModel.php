<?php
	require_once('Model.php');
	class ClientesModel extends Model
	{
		public $id_clientes;
		public $nombre;

		public function __construct()
		{
			$this->db_name = 'ordenservicios';
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
			echo 'Enctro al método Read';
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
			$num_renglones;
			//return $this->rows;
		}

		public function update()
		{

		}
		public function delete()
		{
			
		}

	}
?>