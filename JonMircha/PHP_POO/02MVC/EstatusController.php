<?php
  require_once('EstatusModel.php');
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

    public function create($estatus_data = array())
    {
      return $this->model->create($estatus_data);
    }

    public function update($estatus_data = array())
    {
      return $this->model->update($estatus_data);
    }

    public function delete ($estatus_id  = '')
    {
      return $this->model->delete($estatus_id);
    }

    public function read($estatus_id = '')
    {
      return $this->model->read($estatus_id);
    }
    
  }

?>
