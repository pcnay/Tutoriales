<?php
	//require_once('./Models/UsuariosModel.php'); Se comenta por la funcion "AutoLoad()"
	class UsuariosController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new UsersModel();
		}
		public function __destruct()
		{
			//unset($this);
		}

		public function set($usuario_datos=array() )		
		{
			return $this->modelo->set($usuario_datos);
		}

		public function get($id_usuario='')
		{
			return $this->modelo->get($id_usuario);
		}

		/*
		public function update($usuarios_datos=array())
		{
			return $this->modelo->update($usuarios_datos);
		}
		*/

		public function del($id_usuario='')
		{
			return $this->modelo->del($id_usuario);
		}

	}
	 
?>
