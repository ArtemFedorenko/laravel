<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function getUsers()
    {
        return User::where('role_id', config('defines.userId'))->get();

    }

    public function get($id)
    {
        return User::where(['role_id' => config('defines.userId'), 'id' => $id])->get();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'birthday' => 'date',
            'role_id' => 'integer|exists:roles,id',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($request->user()->role_id == config('defines.superAdminId')) {
            if (!$request['role_id']) {
                $request['role_id'] = 0;
            }
        } else {
            $request['role_id'] = 0;
        }
        $article = User::findOrFail($id);
        $article->update($request->all());
        return $article;
    }

    public function destroy($id)
    {
        $article = User::findOrFail($id);
        $article->delete();

        return 204;

    }
}
