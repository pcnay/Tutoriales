<?php
	//require_once('./Models/ClientesModel.php'); Se comenta por la funcion "AutoLoad()"
	class ClientesController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new ClientesModel();
		}
		public function __destruct()
		{
			//unset($this);
		}

		public function set($clientes_datos=array() )		
		{
			return $this->modelo->set($clientes_datos);
		}

		public function get($id_clientes='')
		{
			return $this->modelo->get($id_clientes);
		}

		/*
		public function update($clientes_datos=array())
		{
			return $this->modelo->update($clientes_datos);
		}
		*/

		public function del($id_clientes='')
		{
			return $this->modelo->del($id_clientes);
		}

	}
	 
?>