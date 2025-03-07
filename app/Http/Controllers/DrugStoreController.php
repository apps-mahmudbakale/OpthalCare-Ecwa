<?php

namespace App\Http\Controllers;

use App\Models\DrugStore;
use Illuminate\Http\Request;

class DrugStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = DrugStore::create($request->all());

        return redirect()->route('app.settings.pharmacy')->with('success', 'Drugs Store Added !');
    }

    /**
     * Display the specified resource.
     */
    public function show(DrugStore $drugStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DrugStore $drugStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DrugStore $drugStore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DrugStore $drugStore)
    {
        //
    }
}
