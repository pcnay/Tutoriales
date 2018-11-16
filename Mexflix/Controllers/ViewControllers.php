<?php
  class ViewControllers
  {
    private static $view_path = './views/'; 

    public function __destruct()
    {
      //unset($this);
    }

    public function load_view($view)
    {
      require_once(self::$view_path. $view. '.php');
    }
  }
?>