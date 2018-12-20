<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar las archivos que requiera cada modulo que se utilize en el sisteme de MexFlix.
  
  // require_once('usersModel.php');
  class UsersController
  {
    private $model;

    // Métodos a utilizar:
    // El controlador no tiene que saber nada de la base de datos.
    public function __construct()
    {
      // Es en esta parte donde se tiene acceso a la Capa Model de la arquitectura MVC.
      $this->model = new UsersModel();

    }

    public function __destruct()
    {
      //unset($this);
    }

    public function set($user_data = array())
    {
      return $this->model->set($user_data);
    }
/*
    public function update($user_data = array())
    {
      return $this->model->update($user_data);
    }
*/
    public function del ($user_id  = '')
    {
      return $this->model->del($user_id);
    }

    public function get($user_id = '')
    {
      return $this->model->get($user_id);
    }
    
  }

?>
