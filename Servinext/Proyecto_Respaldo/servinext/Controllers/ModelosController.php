<?php
	//require_once('./Models/ModelosModel.php'); Se comenta por la funcion "AutoLoad()"
	class ModelosController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new ModelosModel();
		}
		public function __destruct()
		{
			//unset($this);
		}

		public function set($modelos_datos=array() )		
		{
			return $this->modelo->set($modelos_datos);
		}

		public function get($id_modelos='')
		{
			return $this->modelo->get($id_modelos);
		}

		/*
		public function update($modelos_datos=array())
		{
			return $this->modelo->update($modelos_datos);
		}
		*/

		public function del($id_modelos='')
		{
			return $this->modelo->del($id_modelos);
		}

	}
	 
?>