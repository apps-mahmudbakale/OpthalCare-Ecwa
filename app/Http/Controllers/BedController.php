<?php

namespace App\Http\Controllers;

use App\Exports\BedExport;
use App\Imports\BedImport;
use App\Models\Bed;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BedController extends Controller
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
    $bed = Bed::create($request->all());

    return redirect()->route('app.settings.admission')->with('success', 'Bed Added');
  }

  public function export()
  {
    return Excel::download(new BedExport, 'Beds.xlsx');
  }

  public function importView(){
    return view('admission.beds-import');
  }

  public function import(Request $request)
  {
    Excel::import(new BedImport, $request->file('csv')->store('files'));
    return redirect()->back()->with('success', 'Beds data imported successfully!');
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
  public function destroy(Bed $bed)
  {
    $bed->delete();

    return redirect()->route('app.settings.admission')->with('success', 'Bed Delete');
  }
}
