<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan namespace ini benar
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Mengambil semua data user
        return view('users', compact('users'));

    }
}
