<?php

namespace App\Http\Controllers;

use App\Models\IOP;
use App\Models\VisionAcuity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $iop = IOP::create(array_merge($request->all(), ['user_id' => Auth::id()]));
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
  public function edit($iop, $patient)
  {
    $iop = IOP::where('id', $iop)->firstOrFail();
    return view('iop.edit', compact('iop', 'patient'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $iop = IOP::where('id', $id)->first();
    $iop->update($request->all());
    return redirect()->back()->with('success', 'IOP Updated!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $iOP = IOP::find($id);
    if($iOP->delete()) {
      return response()->json(['success' => true]);
    }
  }
}
