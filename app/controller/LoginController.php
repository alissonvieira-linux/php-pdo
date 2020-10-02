<?php

class LoginController
{
  public function show()
  {
    if (!isset($_SESSION["user"])) {
      if (isset($_GET["error"])) {
        $page = ViewController::render("login_invalid_credentials");
        return $page;

      } else {
        $page = ViewController::render("login");
        return $page;
      }

    } else {
      header('Location: '.DEFAULT_URL.'/dashboard');
    }
  }

  public function auth()
  {
    try {
      $user = new User();
      $user->setEmail($_POST["email"]);
      $user->setPassword($_POST["password"]);
      $user->authenticate();
    } catch (\Exception $e) {
      header("Location: ".DEFAULT_URL);
    }  
    
  }

  public function kill()
  {
    unset($_SESSION["user"]);
    session_destroy();

    header('Location: '.DEFAULT_URL);
  }
}