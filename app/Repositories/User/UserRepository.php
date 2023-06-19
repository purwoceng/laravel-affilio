<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use GrahamCampbell\ResultType\Result;

class UserRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        // FIXME
    }

    public function delete($id)
    {
        return User::where('id',$id)->delete();
    }

    public function getUsers($limit, $start)
    {
        return User::offset($start)->limit($limit);
    }

    public function getUserById($id)
    {
        return User::where('id', $id)->first();
    }

    public function getTotalUsers()
    {
        return User::all()->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $user_query = $this->getUsers($limit, $start);
        $total_data = $this->getTotalUsers();

        if ($request->filled('name')) {
            $keyword = $request->get('name');
            $user_query->where('name', 'like', '%' . $keyword . '%');
            $total_data = $user_query->count();

        }

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $user_query->where('username', 'like', '%' . $keyword . '%');
            $total_data = $user_query->count();
        }

        if ($request->filled('email')) {
            $keyword = $request->get('email');
            $user_query->where('email', 'like', '%' . $keyword . '%');
            $total_data = $user_query->count();
        }

        $users = $user_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($users)) {
            foreach ($users  as $key => $user) {
                $id = $user->id;
                $name = $user->name;
                $username = $user->username;
                $email = $user->email;
                $roles = $user->getRoleNames();
                $email_verified_at = $user->email_verified_at;
                $actions = $id;

                $data[] = compact(
                    'id',
                    'name',
                    'username',
                    'email',
                    'roles',
                    'email_verified_at',
                    'actions',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
