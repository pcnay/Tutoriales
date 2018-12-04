<?php
  // Valida si existe el usuario en la base de datos
  class SessionController
  {
    private $session;
    public function __construct()
    {
      // Es donde se creara la session pero siempre y cuando el usuario este registrado.
     $this->session = new UsersModel();

    }

    public function login($user,$pass)
    {
      return $this->session->validate_user($user,$pass);
    }

    public function logout()
    {
      session_start();
      session_destroy();
      header('Location: ./'); // Se retorna al menu de las contraseña.

    }

  }
?>
