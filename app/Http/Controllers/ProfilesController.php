<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        // $user = User::find($user);
        return view('profile.index',compact('user'));
    }
}
