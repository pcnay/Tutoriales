<?php
	//require_once('./Models/TcModel.php'); Se comenta por la funcion "AutoLoad()"
	class TcController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new TcModel();
		}
		public function __destruct()
		{
			//unset($this);
		}

		public function set($tc_datos=array() )		
		{
			return $this->modelo->set($tc_datos);
		}

		public function get($id_tipo_componente='')
		{
			return $this->modelo->get($id_tipo_componente);
		}

		/*
		public function update($tc_datos=array())
		{
			return $this->modelo->update($tc_datos);
		}
		*/

		public function del($id_tipo_componente='')
		{
			return $this->modelo->del($id_tipo_componente);
		}

	}
	 
?>