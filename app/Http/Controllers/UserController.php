<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
    * Instantiate a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Invoke single action controller.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // TODO: Controller logic

        return response()->view('user');
    }
}
