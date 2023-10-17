<?php

namespace App\Http\Controllers;

use App\Models\elementoPizarra;
use App\Models\pizarra;
use App\Models\usuario_pizarra;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pizarras =auth()->user()->participaciones;
        return view('home',compact('pizarras'));
    }


}
