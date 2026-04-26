<?php

namespace App\Http\Controllers;

use App\Models\ConsultingRoom;
use Illuminate\Http\Request;

class ConsultingRoomController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');

    $consultingRooms = ConsultingRoom::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->orderBy('name', 'asc')
      ->paginate($perPage);

    return view('settings.consultation.consulting-rooms', compact('consultingRooms'));
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

    $consultingRoom = ConsultingRoom::create($request->all());

    return redirect()->route('app.consulting-rooms.index')->with('success', 'Consulting Room Added Successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(ConsultingRoom $consultingRoom)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $consultingRoom = ConsultingRoom::findOrFail($id);
    return view('settings.consultation.edit-consulting-room', compact('consultingRoom'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255'
    ]);

    $consultingRoom = ConsultingRoom::findOrFail($id);
    $consultingRoom->update($request->all());

    return redirect()->route('app.consulting-rooms.index')->with('success', 'Consulting Room Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ConsultingRoom $consultingRoom)
  {
    $consultingRoom->delete();

    return redirect()->back()->with('success', 'Consulting Room Deleted Successfully');
  }
}
