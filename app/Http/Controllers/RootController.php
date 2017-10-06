<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Auth;

class RootController extends Controller
{
    public function redirect()
    {
        if (Auth::guest()) {
            return redirect(route('login'));
        }

        return redirect(route('dashboard'));
    }
}