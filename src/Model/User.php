<?php

declare(strict_types=1);

namespace Wondergames\Site\Model;

use DateTime;

class User
{

  private int $id;
  private string $username;
  private string $email;
  private string $password;
  private Datetime $createdAt;
  private Datetime $updatedAt;
  private float $money;
  private int $telefon;
  private string $direccioimatge;
  private int $membership;

  public function __construct(
    string $username,
    string $email,
    string $password,
    Datetime $createdAt,
    Datetime $updatedAt,
    float $money,
    int $telefon,
    string $direccioImatge,
    int $membership

  ) {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
    $this->money = $money;
    $this->telefon = $telefon;
    $this->direccioImatge = $direccioImatge;
    $this->membership = $membership;
  }

  public function id()
  {
    return $this->id;
  }

  public function username()
  {
    return $this->username;
  }

  public function email()
  {
    return $this->email;
  }

  public function password()
  {
    return $this->password;
  }

  public function createdAt()
  {
    return $this->createdAt;
  }

  public function updatedAt()
  {
    return $this->updatedAt;
  }

  public function money()
  {
    return $this->money;
  }

  public function telefon()
  {
    return $this->telefon;
  }

  public function direccioImatge()
  {
    return $this->direccioImatge;
  }

  public function membership(){
      return $this->membership;
  }
}
