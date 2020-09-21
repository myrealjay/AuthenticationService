<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showAll()
    {
        return response()->json(User::all());
    }

    public function showOneUser($id)
    {
        return response()->json(User::findorfail($id));
    }

}
