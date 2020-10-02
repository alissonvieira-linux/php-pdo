<?php

class DashboardController
{
  public function show()
  {
    // Verificando se existe usuário autenticado
    if(!isset($_SESSION["user"])) {
      header('Location: ' .DEFAULT_URL.'/login');
      return;
    }

    $user_name = $_SESSION["user"]["user_name"];

    ViewController::setParam("user_name", $user_name);
    ViewController::setParam("user_age", 26);
    ViewController::setParam("user_class", "Analist and Systems Developer");
    $page = ViewController::render("dashboard");
    return $page;
  }

  public function error()
  {
    echo "Estamos com problemas para processar sua solicitação. Tente novamente mais tarde";
  }
}