<?php

use Database\Connection;

class User
{
  private $id;
  private $name;
  private $email;
  private $password;

  private $conn;

  public function __construct()
  {
    $this->conn = Database\Connection::connect();
  }

  public function save()
  {
    $query = 'INSERT INTO tb_usuarios(usuario_nome, usuario_login, usuario_senha) VALUES(:username, :usermail, :userpass)';

    $stmt = $this->conn->prepare($query);
    $stmt->execute(array
                    (
                    ':username' => $this->name, 
                    ':usermail' => $this->email, 
                    ':userpass' => $this->password
                    ));
    
  }

  public function update()
  {
    $query = 'UPDATE tb_usuarios SET usuario_nome = :name, usuario_login = :email WHERE usuario_id = :id';

    $stmt = $this->conn->prepare($query);
    $stmt->execute(array(
      ':name' => $this->name,
      ':email' => $this->email,
      ':id' => $this->id
    ));
    // Atualizando session, pois os dados dela são utilizados em outras telas
    $_SESSION["user"]["user_name"] = $this->name;
    $_SESSION["user"]["user_email"] = $this->email;

    header('Location: '.DEFAULT_URL.'/user/profile');
  }

  public function authenticate()
  {
    $query = "SELECT * FROM tb_usuarios WHERE usuario_login = :email";

    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':email', $this->email);
    $stmt->execute();
    
    if ($stmt->rowCount()) {
      $user_info = $stmt->fetch(\PDO::FETCH_ASSOC);
      
      if ($user_info["usuario_senha"] === $this->password) {
        // alimentando o restante dos atributos
        $this->setId($user_info["usuario_id"]);
        $this->setName($user_info["usuario_nome"]);

        // Redirecionando para dentro do sistema
        $_SESSION["user"] = array(
                              "user_id" => $this->id,
                              "user_name" => $this->name,
                              "user_email" => $this->email,
                              "user_password" => $this->password
        );
        header('Location: '.DEFAULT_URL. '/dashboard');
      } else {
        header('Location: '.DEFAULT_URL.'/login?error=true');
      }

    } else {
      header('Location: '.DEFAULT_URL.'/login?error=true');
    }

  }

  public function setId($value)
  {
    $this->id = $value;
  }

  public function setName($value)
  {
    $this->name = $value;
  }

  public function setEmail($value)
  {
    $this->email = $value;
  }

  public function setPassword($value)
  {
    $this->password = md5($value);
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

}