<?php

namespace App\Http\Controllers;

use App\Models\ConsultingRoom;
use Illuminate\Http\Request;

class ConsultingRoomController extends Controller
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
    $consultingRoom = ConsultingRoom::create($request->all());

    return redirect()->route('app.settings.consultations')->with('success', 'Consulting Room Added !');
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
  public function edit(ConsultingRoom $consultingRoom)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, ConsultingRoom $consultingRoom)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ConsultingRoom $consultingRoom)
  {
    $consultingRoom->delete();

    return redirect()->route('app.settings.consultations')->with('success', 'Consulting Room Deleted');
  }
}
