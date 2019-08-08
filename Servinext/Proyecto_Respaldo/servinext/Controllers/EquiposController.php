<?php
	//require_once('./Models/EquiposModel.php'); Se comenta por la funcion "AutoLoad()"
	class EquiposController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new EquiposModel();
		}
		public function __destruct()
		{
			//unset($this);
		}

		public function set($equipos_datos=array() )		
		{
			return $this->modelo->set($equipos_datos);
		}

		public function get($id_epo='')
		{
			return $this->modelo->get($id_epo);
		}

		/*
		public function update($equipos_datos=array())
		{
			return $this->modelo->update($equipos_datos);
		}
		*/

		public function del($id_epo='')
		{
			return $this->modelo->del($id_epo);
		}

	}
	 
?>