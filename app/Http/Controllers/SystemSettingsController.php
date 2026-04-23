<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Laboratory;
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

  public function ophthicalSettings()
  {
    return view('settings.ophthical.index');
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

  public function LaboratorySettings(Request $request)
  {
    // Lab Tests
    $testsQuery = Laboratory::query()->with('category');
    if ($request->has('test_search') && $request->test_search) {
      $testsQuery->where('name', 'like', '%' . $request->test_search . '%');
    }
    $testSortBy = $request->get('test_sort_by', 'name');
    $testSortDirection = $request->get('test_sort_direction', 'asc');
    $testsQuery->orderBy($testSortBy, $testSortDirection);
    $testPerPage = $request->get('test_per_page', 10);
    $tests = $testsQuery->paginate($testPerPage, ['*'], 'test_page');

    // Lab Categories
    $categoriesQuery = \App\Models\LabCategory::query();
    if ($request->has('category_search') && $request->category_search) {
      $categoriesQuery->where('name', 'like', '%' . $request->category_search . '%');
    }
    $categorySortBy = $request->get('category_sort_by', 'name');
    $categorySortDirection = $request->get('category_sort_direction', 'asc');
    $categoriesQuery->orderBy($categorySortBy, $categorySortDirection);
    $categoryPerPage = $request->get('category_per_page', 10);
    $categories = $categoriesQuery->paginate($categoryPerPage, ['*'], 'category_page');

    // Lab Parameters
    $parametersQuery = \App\Models\LabParameter::query();
    if ($request->has('parameter_search') && $request->parameter_search) {
      $parametersQuery->where('name', 'like', '%' . $request->parameter_search . '%');
    }
    $parameterSortBy = $request->get('parameter_sort_by', 'name');
    $parameterSortDirection = $request->get('parameter_sort_direction', 'asc');
    $parametersQuery->orderBy($parameterSortBy, $parameterSortDirection);
    $parameterPerPage = $request->get('parameter_per_page', 10);
    $parameters = $parametersQuery->paginate($parameterPerPage, ['*'], 'parameter_page');

    // Lab Templates
    $templatesQuery = \App\Models\LabTemplate::query();
    if ($request->has('template_search') && $request->template_search) {
      $templatesQuery->where('name', 'like', '%' . $request->template_search . '%');
    }
    $templateSortBy = $request->get('template_sort_by', 'name');
    $templateSortDirection = $request->get('template_sort_direction', 'asc');
    $templatesQuery->orderBy($templateSortBy, $templateSortDirection);
    $templatePerPage = $request->get('template_per_page', 10);
    $templates = $templatesQuery->paginate($templatePerPage, ['*'], 'template_page');

    return view('settings.laboratory.index', compact('tests', 'categories', 'parameters', 'templates'));
  }

  public function RadiologySettings()
  {
    return view('settings.radiology.index');
  }

  public function ProcedureSettings()
  {
    return view('settings.procedure.index');
  }

  public function antenatalSettings()
  {
    return redirect()->route('app.antenatal-packages.index');
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
    
    if ($request->has('checkin_fee')) {
        $system->checkin_fee = $request->checkin_fee;
    }

    $system->save();
    return redirect()->route('app.settings.index')->with('System Settings Has Been Updated');
  }
}
