<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar las archivos que requiera cada modulo que se utilize en el sisteme de MexFlix.
  
  // require_once('ArticuloModel.php');
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

    public function set($articulo_data = array())
    {
      return $this->model->set($articulo_data);
    }

    /*
    public function update($articulo_data = array())
    {
      return $this->model->update($articulo_data);
    }
    */

    public function del ($articulo_id  = '')
    {
      return $this->model->del($articulo_id);
    }

    public function get($articulo_id = '')
    {
      return $this->model->get($articulo_id);
    }
    
  }

?>
