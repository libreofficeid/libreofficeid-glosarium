<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Glosarium;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_kata = Glosarium::orderBy('source','asc')->get();
        return view('home',compact('list_kata'));
    }
}
