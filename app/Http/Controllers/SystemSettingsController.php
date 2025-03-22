<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;
use App\Settings\SystemSettings;

class SystemSettingsController extends Controller
{
  public function index(SystemSettings $system)
  {
    $currencies = ['&#36;', '&#8361;', '&#8364;', '&#8377;', '&#8358;', '&#165;'];
    return view('settings.index', compact('system', 'currencies'));
  }


  public function admissionSettings()
  {
    return view('settings.admission.index');
  }

  public function antenatalSettings()
  {
    return view('settings.antenatal.index');
  }

  public function consultationSettings()
  {
    return view('settings.consultation.index');
  }

  public function consumablesSettings()
  {
    return view('settings.consumables.index');
  }

  public function PharmacySettings()
  {
    return view('settings.pharmacy.index');
  }

  public function LaboratorySettings()
  {
    return view('settings.laboratory.index');
  }

  public function RadiologySettings()
  {
    return view('settings.radiology.index');
  }

  public function ProcedureSettings()
  {
    return view('settings.procedure.index');
  }

  public function updateSystemSettings(Request $request, SystemSettings $system)
  {
    // $this->validate($request, [
    //   'clinic_name' => 'required',
    //   'address' => 'required',
    //   'footer' => 'required',
    //   'logo' => 'nullable|file|image',
    //   'favicon' => 'nullable|file|image',

    // ]);

    if ($request->hasFile('logo')) {
      $logo = time() . '.' . $request->logo->extension();
      $request->file('logo')->storeAs('public/system', $logo);
    }
    if ($request->hasFile('favicon')) {
      $favicon = time() . '.' . $request->favicon->extension();
      $request->file('favicon')->storeAs('public/system', $favicon);
    }

    $system->clinic_name = $request->clinic_name;
    if ($request->hasFile('logo')) {
      $system->logo = $logo;
    }
    if ($request->hasFile('favicon')) {
      $system->favicon = $favicon;
    }

    $system->address = $request->address;
    $system->footer = $request->footer;
    $system->number_prefix = $request->number_prefix;
    $system->insurance_providers = $request->has('insurance_providers');
    $system->auto_bill = $request->has('auto_bill');
    $system->check_in = $request->has('check_in');
    $system->save();
    return redirect()->route('app.settings.index')->with('System Settings Has Been Updated');
  }
}
