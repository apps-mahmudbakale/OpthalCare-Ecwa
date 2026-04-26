<?php

namespace App\Http\Controllers;

use App\Models\AppointmentType;
use Illuminate\Http\Request;

class AppointmentTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $appointmentTypes = AppointmentType::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->orderBy('name', 'asc')
      ->paginate($perPage);

    return view('settings.consultation.appointment-types', compact('appointmentTypes'));
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

    $appointmentType = AppointmentType::create($request->all());
    return redirect()->route('app.appointment-type.index')->with('success', 'Appointment Type Added Successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(AppointmentType $appointmentType)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $appointmentType = AppointmentType::findOrFail($id);
    return view('settings.consultation.edit-appointment-type', compact('appointmentType'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255'
    ]);

    $appointmentType = AppointmentType::findOrFail($id);
    $appointmentType->update($request->all());

    return redirect()->route('app.appointment-type.index')->with('success', 'Appointment Type Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(AppointmentType $appointmentType)
  {
    $appointmentType->delete();
    return redirect()->back()->with('success', 'Appointment Type Deleted Successfully');
  }
}
