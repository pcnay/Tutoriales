<?php
	class Router
	{
		public $route;
		public function __construct($route)
		{
			if (!isset($_SESSION))
			{
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
			// Controla el flujo de la aplicación
			if($_SESSION['ok'])
			{
				// Toda la programación de la aplicación.
				// Se maneja las rutas de la aplicación
				//Determina que ruta va a seguir.
				$this->route = (isset($_GET['r']))?$_GET['r']:'home';
				$controller = new ViewController();
				
				switch ($this->route)
				{
					case 'home':
						$controller->load_view('home');	
					break;
					case 'clientes':
						// Viene desde Clientes.php
						if (!isset($_POST['r']))
							$controller->load_view('clientes');
						else if($_POST['r'] == 'clientes-add')
							$controller->load_view('clientes-add');						
						else if($_POST['r'] == 'clientes-edit')
							$controller->load_view('clientes-edit');
						else if($_POST['r'] == 'clientes-delete')
							$controller->load_view('clientes-delete');										
					break;
					case 'usuarios':
						// Viene desde Usuarios.php
						if (!isset($_POST['r']))
							$controller->load_view('usuarios');
						else if($_POST['r'] == 'usuarios-add')
							$controller->load_view('usuarios-add');						
						else if($_POST['r'] == 'usuarios-edit')
							$controller->load_view('usuarios-edit');
						else if($_POST['r'] == 'usuarios-delete')
							$controller->load_view('usuarios-delete');										
					break;
					case 'sucursales':
						$controller->load_view('sucursales');
					break;
					case 'marcas':
						$controller->load_view('marcas');
					break;
					case 'historicos':
						$controller->load_view('historicos');
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
				//Mostrar un formulario de Autenticación.
				// Se utilizaran controladores para las vistas
				// Si no esta definida las variables globales "user" y "password", carga la vista de "login", esta se origina cuando la primera vez se oprime el boton de "Enviar"
				if (!isset($_POST['user']) && !isset($_POST['pass']))
				{ 
					$login_form = new ViewController();
					$login_form->load_view('login');
					//Cuando se procesa el formulario (Se oprime el boton "Enviar"), se regresa el flujo de ejecución del programa desde el inicio del archivo "Router.php" y vuelve a validar, en esta ocación no se cumple esta condición porque ya tienen valores las variables globales "user" y "passs", ejecuta el "else"
				}
				else 
				{
					// Se da acceso a la aplicación.
					$user_session = new SessionController();
					// Esta funcion de la clase SessionController, valida si el usuario existe.
					$session = $user_session->login($_POST['user'],$_POST['pass']);
					// Regresa un arreglo, de una solo posicion.
					if (empty($session))
					{
						// No existe el usuario
						// Se tiene que ejecutar de nuevo la clase "ViewController"
						$login_form = new ViewController();
						$login_form->load_view('login');
						// Se redirecciona el flujo de la aplicación, al Home de la aplicación
						header('Location: ./?error=El usuario '.$_POST['user']. ' y el password proporcionado no coinciden');
							
					}
					else
					{
						echo '$_session[ ok ] se genera las variables de session de los datos usaurios';
						// Se crea una sesion de usuario para entrar el menu del sistema.
						//echo 'El usuario y contraseña son correctos';
						$_SESSION['ok'] = true;
						// Se guardaran en variables de SESSION los datos del usuario que se firmo
						foreach ($session as $row)
						{
							$_SESSION['usuario'] = $row['usuario'];
							$_SESSION['email'] = $row['email'];
							$_SESSION['nombre'] = $row['nombre'];
							$_SESSION['cumpleanos'] = $row['cumpleanos'];
							$_SESSION['clave'] = $row['clave'];
							$_SESSION['perfil'] = $row['perfil'];
						}

						// Se regresa el flujo de la ejecución de la aplicación al "home" de la aplicación, vuelve a ejecutar la clase "Router", comienza a validar, pero ahora se ejecutara el "if($_SESSION['ok'])	// Toda la programación de la aplicación.	
						header ('Location: ./');

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