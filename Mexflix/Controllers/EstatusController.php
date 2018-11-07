<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar las archivos que requiera cada modulo que se utilize en el sisteme de MexFlix.
  
  // require_once('EstatusModel.php');
  class EstatusController
  {
    private $model;

    // Métodos a utilizar:
    // El controlador no tiene que saber nada de la base de datos.
    public function __construct()
    {
      // Es en esta parte donde se tiene acceso a la Capa Model de la arquitectura MVC.
      $this->model = new EstatusModel();

    }

    public function __destruct()
    {
      //unset($this);
    }

    public function set($estatus_data = array())
    {
      return $this->model->set($estatus_data);
    }
/*
    public function update($estatus_data = array())
    {
      return $this->model->update($estatus_data);
    }
*/
    public function del ($estatus_id  = '')
    {
      return $this->model->del($estatus_id);
    }

    public function get($estatus_id = '')
    {
      return $this->model->get($estatus_id);
    }
    
  }

?>
