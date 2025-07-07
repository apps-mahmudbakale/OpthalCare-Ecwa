<?php

namespace App\Http\Controllers;

use App\Models\Antenatal;
use App\Models\OpticalRequest;
use Illuminate\Http\Request;

class OpticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('opticals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opticals = Antenatal::all();
        return view('opticals.create', compact('opticals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request_ref = str()->random(6);

      $request = OpticalRequest::create(array_merge($request->all(), ['ref' => $request_ref, 'user_id' => auth()->user()->id, 'status' => 'pending']));

     return redirect()->back()->with('success', 'Request Submitted');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
