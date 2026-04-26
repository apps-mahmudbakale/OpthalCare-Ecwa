<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $wards = Ward::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->orderBy('name', 'asc')
      ->paginate($perPage);

    return view('settings.admission.wards', compact('wards'));
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
      'name' => 'required|string|max:255'
    ]);

    $ward = Ward::create($request->all());

    return redirect()->route('app.wards.index')->with('success', 'Ward Added Successfully');
  }

  public function getBedsByWard($wardId)
  {
//    $wardId = $request->input('ward_id');
    $beds = Ward::find($wardId)->beds()->where('available', true)->get();
    return $beds;
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
    $ward = Ward::findOrFail($id);
    return view('settings.admission.edit-ward', compact('ward'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255'
    ]);

    $ward = Ward::findOrFail($id);
    $ward->update($request->all());

    return redirect()->route('app.wards.index')->with('success', 'Ward Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Ward $ward)
  {
    $ward->delete();

    return redirect()->back()->with('success', 'Ward Deleted Successfully');
  }
}
