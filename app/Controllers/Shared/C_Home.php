<?php

namespace App\Controllers\Shared;

class C_Home extends C_Base
{
    public function index(): string
    {
        return view('V_Landing');
    }
}
