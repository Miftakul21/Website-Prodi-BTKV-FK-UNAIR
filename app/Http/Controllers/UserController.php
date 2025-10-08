<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class UserController extends Controller
{
    // protected $middleware = ['permission:anggota'];

    public function index()
    {
        return view('user.index');
    }
}
