<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;

class UserService
{
    public function getAll(): PaginationLengthAwarePaginator
    {
        return User::latest()->paginate(User::PAGINATION);
    }

    public function find(int $id) : User
    {
        return User::findOrFail($id);
    }

    public function store(array $data) : User
    {
        return User::create($data);
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
