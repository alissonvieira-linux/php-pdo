<?php

class UserController 
{

  public function show()
  {
    //Carregando a página de registro
    $page = ViewController::render("register");
    return $page;
  }

  public function create()
  {

    if(isset($_POST["name"]))
    {
      $user = new User;

      $user->setName($_POST["name"]);
      $user->setEmail($_POST["email"]);
      $user->setPassword($_POST["password"]);
      $user->save();
    }

  }

  public function update()
  {
    try {
      $user = new User;

      if (isset($_POST["name"]) && isset($_POST["email"])) {
        $user->setId($_SESSION["user"]["user_id"]);
        $user->setName($_POST["name"]);
        $user->setEmail($_POST["email"]);
        $user->update();
      } else {
        header('Location: '.DEFAULT_URL.'/dashboard/error');
      }
      
    } catch (\Exception $e) {
      header('Location: '.DEFAULT_URL.'/dashboard/error');
    }
    
  }

  public function profile()
  {
    ViewController::setParam("user_name", $_SESSION["user"]["user_name"]);
    ViewController::setParam("user_email", $_SESSION["user"]["user_email"]);
    $page = ViewController::render("profile");
    return $page;
  }
}