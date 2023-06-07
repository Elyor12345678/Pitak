<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('car-list.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('car-list.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('car-list.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('car-list.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('car-list.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('car-list.index');
    }
}
