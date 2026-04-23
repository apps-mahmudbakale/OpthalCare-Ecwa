<?php

namespace App\Http\Controllers;

use App\Models\HmoService;
use Illuminate\Http\Request;

class HmoServiceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(\App\Models\HmoPlan $plan)
    {
        $hmoPlan = $plan;
        
        $categories = [
            'admissions' => 'Admissions',
            'antenatal' => 'Antenatal/Ophthicals',
            'consultations' => 'Consultations',
            'laboratory' => 'Laboratory',
            'pharmacy' => 'Pharmacy',
            'procedure' => 'Procedure',
            'radiology' => 'Radiology',
        ];

        return view('hmo-services.create', compact('hmoPlan', 'categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Models\HmoPlan $plan)
    {
        $hmoPlan = $plan;
        // Don't eager load 'service' anymore since it's removed
        // Add pagination with 20 items per page
        $assignedServices = HmoService::where('plan_id', $hmoPlan->id)
            ->paginate(20)
            ->appends($request->query());
        
        $categories = [
            'admissions' => 'Admissions',
            'antenatal' => 'Antenatal/Ophthicals',
            'consultations' => 'Consultations',
            'laboratory' => 'Laboratory',
            'pharmacy' => 'Pharmacy',
            'procedure' => 'Procedure',
            'radiology' => 'Radiology',
        ];

        return view('hmo-services.index', compact('hmoPlan', 'assignedServices', 'categories'));
    }

    public function store(Request $request, \App\Models\HmoPlan $plan)
    {
        $request->validate([
            'type' => 'required|string',
            'service_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
        ]);

        $exists = HmoService::where('plan_id', $plan->id)
            ->where('type', $request->type)
            ->where('service_id', $request->service_id)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'This service is already added to this plan.'], 422);
        }

        HmoService::create([
            'plan_id' => $plan->id,
            'type' => $request->type,
            'service_id' => $request->service_id,
            'price' => $request->price,
        ]);

        return response()->json(['success' => true, 'message' => 'Service added successfully.']);
    }

    public function update(Request $request, HmoService $hmoService)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $hmoService->update(['price' => $request->price]);

        return response()->json(['success' => true, 'message' => 'Service price updated.']);
    }

    public function destroy(HmoService $hmoService)
    {
        $hmoService->delete();
        return response()->json(['success' => true, 'message' => 'Service removed from plan.']);
    }

    public function export(\App\Models\HmoPlan $plan)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\HmoPlanServicesExport($plan->id), 
            $plan->name . '_services.xlsx'
        );
    }

    public function importView(\App\Models\HmoPlan $plan)
    {
        $hmoPlan = $plan;
        return view('hmo-services.import', compact('hmoPlan'));
    }

    public function import(Request $request, \App\Models\HmoPlan $plan)
    {
        $request->validate([
            'csv' => 'required|mimes:csv,xlsx,xls'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\HmoPlanServiceImport($plan->id), $request->file('csv')->store('files'));
        
        return redirect()->back()->with('success', 'Plan Services pricing imported successfully!');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\HmoPlanServiceTemplateExport(), 'hmo_service_import_template.xlsx');
    }
}
