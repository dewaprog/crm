<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        // return view('welcome_message');
        return view('user/user_view');
    }
}
