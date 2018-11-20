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
      // Se agregan la Cabezera, Cuerpo y Pie de página  del documento en cuestion.
      require_once(self::$view_path. 'header.php');
      require_once(self::$view_path. $view. '.php');
      require_once(self::$view_path. 'footer.php');
    }
  }
?>