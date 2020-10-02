<?php

class Core
{
  private $url = array();
  private $controller;
  private $method = "show";
  private $params = array();

  public function __construct()
  {

  }

  public function start($request)
  {
    if (isset($request["url"])) {
      $this->url = explode('/', $request["url"]);
      
      $this->controller = ucfirst($this->url[0])."Controller";

      if(isset($this->url[1])) {
        $this->method = $this->url[1];
      }

      if(isset($this->url[2])) {
        $this->params = $this->url[2];
      }
      
    } else {
      $this->controller = "LoginController";
      $this->method = "show";
    }

    return call_user_func(array(new $this->controller, $this->method), $this->params);
    
  }
}