<?php

namespace App\Controllers;

class C_Home extends BaseController
{
    public function index(): string
    {
        return view('landing');
    }
}
