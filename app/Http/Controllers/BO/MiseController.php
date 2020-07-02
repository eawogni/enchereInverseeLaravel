<?php

namespace App\Http\Controllers\BO;

use App\Http\Controllers\Controller;
use App\Mise;
use Illuminate\Http\Request;

class MiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_role:admin');
        //$this->middleware('verified');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Mise.index',['mises'=>Mise::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mise  $mise
     * @return \Illuminate\Http\Response
     */
    public function show(Mise $mise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mise  $mise
     * @return \Illuminate\Http\Response
     */
    public function edit(Mise $mise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mise  $mise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mise $mise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mise  $mise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mise $mise)
    {
        //
    }
}
