<?php

namespace App\Http\Controllers;

use App\Models\IOP;
use Illuminate\Http\Request;

class IOPController extends Controller
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
    $iop = IOP::create($request->all());
    return redirect()->back()->with('success', 'IOP Added!');
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $iOP = IOP::find($id);
    // dd($iOP);
    return view('iop.details', compact('iOP'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(IOP $iOP)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, IOP $iOP)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(IOP $iOP)
  {
    //
  }
}
