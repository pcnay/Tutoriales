<?php
  require_once('ArticuloModel.php');
  class ArticuloController
  {
    private $model;

    // Métodos a utilizar:
    // El controlador no tiene que saber nada de la base de datos.
    public function __construct()
    {
      // Es en esta parte donde se tiene acceso a la Capa Model de la arquitectura MVC.
      $this->model = new ArticuloModel();

    }

    public function __destruct()
    {
      //unset($this);
    }

    public function create($articulo_data = array())
    {
      return $this->model->create($articulo_data);
    }

    public function update($articulo_data = array())
    {
      return $this->model->update($articulo_data);
    }

    public function delete ($articulo_id  = '')
    {
      return $this->model->delete($articulo_id);
    }

    public function read($articulo = '')
    {
      return $this->model->read($articulo_id);
    }
    
  }

?>
