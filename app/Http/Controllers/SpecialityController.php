<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $specialities = Speciality::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->orderBy('name', 'asc')
      ->paginate($perPage);

    return view('settings.consultation.specialities', compact('specialities'));
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

    $speciality = Speciality::create($request->all());

    return redirect()->route('app.specialities.index')->with('success', 'Speciality Added Successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Speciality $speciality)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $speciality = Speciality::findOrFail($id);
    return view('settings.consultation.edit-speciality', compact('speciality'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255'
    ]);

    $speciality = Speciality::findOrFail($id);
    $speciality->update($request->all());

    return redirect()->route('app.specialities.index')->with('success', 'Speciality Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Speciality $speciality)
  {
    $speciality->delete();

    return redirect()->back()->with('success', 'Speciality Deleted Successfully');
  }
}
