<?php

namespace App\Services\Implementation;

use App\Services\IUserService;

use App\Models\User;
use Exception;

class UserService implements IUserService
{
    private $usersRepository;

    public function __construct(User $user)
    {
        $this->usersRepository = $user;
    }

    public function CreateUser(array $user)
    {
        $user['password'] = bcrypt($user['password']);
        return $this->usersRepository->create($user);
    }

    public function EditUser(array $user)
    {
        $userId = $user["id"];
        $userToUpdate = $this->usersRepository->find($userId);
        if (!$userToUpdate) {
            throw new Exception("There is no user stored with the id: $userId");
        }

        $userToUpdate->name = $user["name"];
        $userToUpdate->email = $user["email"];
        $userToUpdate->save();

        return $userToUpdate;
    }

    public function DeleteUser($userId)
    {
        $userToDelete = $this->usersRepository->find($userId);
        if (!$userToDelete) {
            throw new Exception("There is no user stored with the id: $userId");
        }

        $userDeleted = $userToDelete->toArray();
        $userToDelete->delete();
        return $userDeleted;
    }
}
