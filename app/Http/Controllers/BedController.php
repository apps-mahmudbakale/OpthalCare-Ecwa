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
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $beds = Bed::query()
      ->with('ward')
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%')
          ->orWhereHas('ward', function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
          });
      })
      ->orderBy('name', 'asc')
      ->paginate($perPage);

    return view('settings.admission.beds', compact('beds'));
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
    $request->validate([
      'name' => 'required|string|max:255',
      'ward_id' => 'required|exists:wards,id',
      'price' => 'required|numeric|min:0'
    ]);

    $bed = Bed::create($request->all());

    return redirect()->route('app.beds.index')->with('success', 'Bed Added Successfully');
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
  public function edit($id)
  {
    $bed = Bed::with('ward')->findOrFail($id);
    $wards = \App\Models\Ward::all();
    return view('settings.admission.edit-bed', compact('bed', 'wards'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'ward_id' => 'required|exists:wards,id',
      'price' => 'required|numeric|min:0'
    ]);

    $bed = Bed::findOrFail($id);
    $bed->update($request->all());

    return redirect()->route('app.beds.index')->with('success', 'Bed Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Bed $bed)
  {
    $bed->delete();

    return redirect()->back()->with('success', 'Bed Deleted Successfully');
  }
}
