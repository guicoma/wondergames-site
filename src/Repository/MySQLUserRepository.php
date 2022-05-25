<?php

declare(strict_types=1);

namespace Wondergames\Site\Repository;

use PDO;
use Wondergames\Site\Model\User;
use Wondergames\Site\Repository\UserRepository;

final class MySQLUserRepository implements UserRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private PDO $databaseConnection;

    public function __construct(PDO $database)
    {
        $this->databaseConnection = $database;
    }

    public function createUser(User $user): void
    {
        $query = <<<'QUERY'
        INSERT INTO users(username, email, password, createdAt, updatedAt,money , telefon ,direccioImatge, membership)
        VALUES(:username, :email, :password, :createdAt, :updatedAt, :money, :telefon, :direccioImatge, :membership)
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $username = $user->username();
        $email = $user->email();
        $password = $user->password();
        $createdAt = $user->createdAt()->format(self::DATE_FORMAT);
        $updatedAt = $user->updatedAt()->format(self::DATE_FORMAT);
        $money = $user->money();
        $telefon = $user->telefon();
        $direccioImatge= $user ->direccioImatge();
        $membership= $user ->membership();


        $statement->bindParam('username', $email, PDO::PARAM_STR);
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $statement->bindParam('createdAt', $createdAt, PDO::PARAM_STR);
        $statement->bindParam('updatedAt', $updatedAt, PDO::PARAM_STR);
        $statement->bindParam('money', $money, PDO::PARAM_STR);
        $statement->bindParam('telefon', $telefon, PDO::PARAM_STR);
        $statement->bindParam('direccioImatge', $direccioImatge, PDO::PARAM_STR);
        $statement->bindParam('membership', $membership, PDO::PARAM_STR);

        $statement->execute();
    }

    
    public function updatePassword(int $id, string $password)
    {

        $query = <<<'QUERY'
        UPDATE users SET password = :password WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }


    public function getUserByEmail(string $email)
    {
        $query = <<<'QUERY'
        SELECT * FROM users WHERE email = :email
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('email', $email, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }

 
   
    public function updateTelefon(int $id, string $telefon)
    {
        $query = <<<'QUERY'
        UPDATE users SET telefon = :telefon WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);
        $statement->bindParam('telefon', $telefon, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }
    


    public function updateProfile(int $id, string $username, int $telefon, string $direccioImatge)
    {
        $query = <<<'QUERY'
        UPDATE users SET username = :username, telefon = :telefon, direccioImatge = :direccioImatge WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);
        $statement->bindParam('username', $username, PDO::PARAM_STR);
        $statement->bindParam('telefon', $telefon, PDO::PARAM_STR);
        $statement->bindParam('direccioImatge', $direccioImatge, PDO::PARAM_STR);
        // $statement->bindParam('direccioImatge', $direccioImatge, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }


    
    public function getUserById(int $id)
    {
        $query = <<<'QUERY'
        SELECT * FROM users WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }

    public function getMoney(int $id)
    {
        $query = <<<'QUERY'
        SELECT money FROM users WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }

    public function setMoney(int $id, float $money)
    {
        $query = <<<'QUERY'
        UPDATE users SET money = :money WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);
        $statement->bindParam('money', $money, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }

    public function getMembership(int $id)
    {
        $query = <<<'QUERY'
        SELECT membership FROM users WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }

    public function setMembership(int $id, int $membership)
    {
        $query = <<<'QUERY'
        UPDATE users SET membership = :membership WHERE id = :id
        QUERY;

        $statement = $this->databaseConnection->prepare($query);

        $statement->bindParam('id', $id, PDO::PARAM_STR);
        $statement->bindParam('membership', $membership, PDO::PARAM_STR);

        $statement->execute();

        $count = $statement->rowCount();
        if ($count > 0) {
            $row = $statement->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        return null;
    }
}
