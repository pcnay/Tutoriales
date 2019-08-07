<?php
	//require_once('./Models/MarcasModel.php'); Se comenta por la funcion "AutoLoad()"
	class MarcasController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new MarcasModel();
		}
		public function __destruct()
		{
			//unset($this);
		}

		public function set($marcas_datos=array() )		
		{
			return $this->modelo->set($marcas_datos);
		}

		public function get($id_marcas='')
		{
			return $this->modelo->get($id_marcas);
		}

		/*
		public function update($marcas_datos=array())
		{
			return $this->modelo->update($marcas_datos);
		}
		*/

		public function del($id_marcas='')
		{
			return $this->modelo->del($id_marcas);
		}

	}
	 
?>