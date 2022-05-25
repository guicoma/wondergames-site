<?php

declare(strict_types=1);

namespace Wondergames\Site\Repository;

use Wondergames\Site\Model\User;

interface UserRepository
{
    public function createUser(User $user): void;
    public function getUserByEmail(string $email);
    public function getUserById(int $id);
    public function getMoney(int $id);
    public function setMoney(int $id, float $money);
    //public function setTelefon(int $id, int $telefon);
    public function updateProfile(int $id, string $username, int $telefon, string $direccioImatge);
    //ublic function updateTelefon(int $id, string $telefon);
    public function updatePassword(int $id, string $password);
    public function getMembership(int $id);
    public function setMembership(int $id, int $membership);
}


