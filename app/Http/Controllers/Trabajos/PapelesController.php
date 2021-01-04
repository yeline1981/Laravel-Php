<?php

namespace App\Http\Controllers\Trabajos;

use App\Models\Papeles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PapelesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Papeles::select('id', 'papel')->get();
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
        $nuevo = new Papeles();
        $nuevo->papel = $request->papel;
        $nuevo->save();

        return ['id' => $nuevo->id];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Papeles  $papeles
     * @return \Illuminate\Http\Response
     */
    public function show(Papeles $papeles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Papeles  $papeles
     * @return \Illuminate\Http\Response
     */
    public function edit(Papeles $papeles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Papeles  $papeles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Papeles $papeles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Papeles  $papeles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Papeles $papeles)
    {
        //
    }
}
