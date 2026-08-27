<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    public function getAll()
    {
        User::latest();
    }

    public function find(int $id) : User
    {
        return User::findOrFail($id);
    }

    public function store(array $data) : User
    {
        return User::store($data);
    }

    public function update(int $id, array $data) : User
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function destroy(int $id) : User
    {
        $user = $this->find($id);
        $user->delete();
        return $user;
    }

}
