<?php
  // Se comenta esta línea porque en el "Controller" se va crear una función que va autocargar las archivos que requiera cada modulo que se utilize en el sisteme de MexFlix.
  
  // require_once('MovieseriesModel.php');
  class MovieSeriesController
  {
    private $model;

    // Métodos a utilizar:
    // El controlador no tiene que saber nada de la base de datos.
    public function __construct()
    {
      // Es en esta parte donde se tiene acceso a la Capa Model de la arquitectura MVC.
      $this->model = new MovieSeriesModel();

    }

    public function __destruct()
    {
      //unset($this);
    }

    public function set($ms_data = array())
    {
      return $this->model->set($ms_data);
    }
/*
    public function update($ms_data = array())
    {
      return $this->model->update($ms_data);
    }
*/
    public function del ($ms_id  = '')
    {
      return $this->model->del($ms_id);
    }

    public function get($ms_id = '')
    {
      return $this->model->get($ms_id);
    }
    
  }

?>
