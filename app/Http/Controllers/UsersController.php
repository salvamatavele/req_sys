<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index',[
            'title'=> "Usuários",
            'users' => User::all(),
        ]);
    }
    public function create()
    {
        return view('users.create');
    }

    public function edit(int $id)
    {
        return view('users.edit',[
            "user" => User::findOrFail($id),
        ]);
    }

    public function store(UsersRequest $usersRequest)
    {
        $userData = $usersRequest->all();
        $userData['password'] = Hash::make($userData['password']);
        $user = User::create($userData);
        if ($user) {
            return Redirect::route('users.index')->with('success', "O usuário foi registado com sucesso.");
        } else {
            return Redirect::back(500)->with('error',"Ooops! Erro ao tentar registar o usuário, tente novamente.");
        }

    }

    public function update(UsersRequest $usersRequest, int $id)
    {
        $userData = $usersRequest->except("password");
        $user = User::findOrFail($id);
        $updated = $user->update($userData);
        if ($updated) {
            return Redirect::route('users.index')->with('success', "O usuário foi actualizado com sucesso.");
        } else {
            return Redirect::back(500)->with('error',"Ooops! Erro ao tentar actualizar o usuário, tente novamente.");
        }

    }

    public function delete(int $id)
    {
        try {
            User::destroy($id);
            return Redirect::back()->with('success',"Usuário eliminado com sucesso.");
        } catch (\Throwable $e) {
            return Redirect::back()->with('error',"Ooops! Erro ao tentar eliminar o usuário, tente novamente.");
        }
    }
}
