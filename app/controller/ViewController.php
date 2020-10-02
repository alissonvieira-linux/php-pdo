<?php

class ViewController
{
  private static $params = array();

  public static function render($template_name)
  {

    $loader = new \Twig\Loader\FilesystemLoader('app/view');
    $twig = new \Twig\Environment($loader);

    $template = $twig->load($template_name.'.html');
    return $template->render(self::$params);
  }

  public static function setParam($key, $value)
  {
    self::$params[$key] = $value;
  }
}