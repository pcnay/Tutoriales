<?php
  // Se definen las rutas que se tendrán en la aplicación.
  class Router
  {
    // $route = El valor proviene del archivo "index.php"
    public $route;
    public function __construct($route)
    {
      // Determinara primero si existe la sesion o no.
      // Cuando inicia por primera vez crea la sesion.
      if ( !isset($_SESSION) )
      {
        // http://php.net/manual/es/function.session-start.php    
        // Revisar el archivo de configuracion "PHP.INI", en XAMPP.
        // se agrega un arreglo como parametro en la PHP 7, modifican en PHP.ini
        // Valores minímos para que opera la sesión en PHP 7
        
        session_start([
          "use_only_cookies" => 1,
          //x Este valor es solo modificable en ".htaccess, httpd.conf,user.ini
          // No tine sentido en tiempo de ejecución decirle a PHP que autinicie sesion
          // a la vez que inicias session.
          "auto_start", // <=======
          "read_and_close" => false // La sesion se cierre automaticamente.
                                    // Si se coloca a "true" no funciona la variable Global 
                                    // $_SESSION['ok'],


          /* Valores originales, pero no funciona en PHP Ver 7 
          "use_only_cookies" => 1,
          "auto_start" => 1,
          "read_and_close" => true
          */

        ]);
        
      }
      
      if (!isset($_SESSION['ok']))
      {
        $_SESSION['ok'] = false;        
      }

      
      
      // cuando se crea la sesion se asignara a la variable sesion "ok" el valor de true
      if ($_SESSION['ok'])
      {
        // Abarcara toda la programación perminente de la aplicación
        // Se manejan las rutas que maneja la aplicación.
        // Selecciona de acuerdo los seleccionado en el menú.
        $this->route = isset($_GET['r']) ? $_GET['r']:'home';
        $controller = new ViewControllers();

          switch ($this->route)
          {
            case 'home':                      
              $controller->load_view('home');
              break;
            case 'inventarios':
              $controller->load_view('inventarios');              
              break;           
            case 'sgi':
              $controller->load_view('sgi');
              break;
            case 'varios':
              $controller->load_view('varios');
              break;
            case 'articulos':
              // Se determina si se oprimio el boton de "Agregar", "Editar", "Borrar" de la lista mostrada.
              // De la vista "articulos.php"
              if (!isset($_POST['r']))
              {
                $controller->load_view('articulos');                
              }
              else if($_POST ['r'] == 'articulo-add')
              {
                $controller->load_view('articulo-add');       
              }
              else if($_POST ['r'] == 'articulo-edit')
              {
                $controller->load_view('articulo-edit');       
              }
              else if($_POST ['r'] == 'articulo-delete')
              {
                $controller->load_view('articulo-delete');       
              }
            break;
            case 'salir':
              $user_session = new SessionController();
              $user_session->logout();
              break;
            default:
              $controller->load_view('error404');
              break;
          }      
      }
      else
      {
        if(!isset($_POST['user']) && !isset($_POST['pass']))
        {
          // Se desplegará un formulario de autenticación.
          // Esta clase es para mostrar las vistas en la aplicación Mexflix, se pasara como parámetro la vista que se desea mostrar.
          $controller = new ViewControllers();
          $controller->load_view('login');
        } 
        else
        { 
          // La clave para dar acceso al sistema
          // Se crea un nuevo controlador "Sesion de usuario"
          $user_session = new SessionController();
          $session = $user_session->login($_POST['user'],$_POST['pass']);
          if (empty($session))
          {
            // echo "El usuario y el password son incorrectos";

            $login_form = new ViewControllers();
            $login_form->load_view('login');
            // Se redirije el flujo de la aplicación. Al raíz de la aplicación.
            header('Location: ./?error=El usuario '.$_POST['user']. ' y el password proporcionado no coinciden');
          }
          else
          {
            // echo "El usuario y password son correctos";
            $_SESSION['ok'] = true;

            // Se crean las variables de session, estas permanecen aun cuando se cambian las rutas.
            // En esta config. del Foreach se cambia para valor unidimencional
            foreach ($session as $row)
            {
              $_SESSION['user'] = $row['user'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['names'] = $row['names'];
              $_SESSION['birthday'] = $row['birthday'];
              $_SESSION['pass'] = $row['pass'];
              $_SESSION['roles'] = $row['roles'];
            }


            //Redirige el flujo de la aplicación al directorio raíz y vuelve a comenzar la ejecución de la aplicación. "HOME" de la aplicación.
            header('Location: ./'); 
            
          }
          

        }

      }

    }
    public function __destruct()
    {
      //unset($this);
    }


  }
?>
