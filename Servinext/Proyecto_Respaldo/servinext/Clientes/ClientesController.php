<?php
	require_once('ClientesModel.php');
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

		public function create($clientes_datos=array() )		
		{
			return $this->modelo->create($clientes_datos);
		}

		public function read($id_clientes='')
		{
			return $this->modelo->read($id_clientes);
		}

		public function update($clientes_datos=array())
		{
			return $this->modelo->update($clientes_datos);
		}
		public function delete($id_clientes='')
		{
			return $this->modelo->delete($id_clientes);
		}

	}
	 
?>