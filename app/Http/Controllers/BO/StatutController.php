<?php


namespace App\Http\Controllers\BO;

use App\Http\Controllers\Controller;
use App\Statut;
use Illuminate\Http\Request;

class StatutController extends Controller
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
        //
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
     * @param  \App\Statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function show(Statut $statut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function edit(Statut $statut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statut $statut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statut $statut)
    {
        //
    }
}
