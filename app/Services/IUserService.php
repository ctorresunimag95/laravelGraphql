<?php

namespace App\Services;

interface IUserService
{
    public function CreateUser(array $user);
    public function EditUser(array $user);
    public function DeleteUser($userId);
}
