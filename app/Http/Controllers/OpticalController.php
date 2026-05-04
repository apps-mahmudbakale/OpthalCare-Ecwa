<?php

namespace App\Http\Controllers;

use App\Models\Antenatal;
use App\Models\OpticalRequest;
use Illuminate\Http\Request;

class OpticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('opticals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opticals = Antenatal::all();
        return view('opticals.create', compact('opticals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $service_ids = $request->input('service_id');
        $comments = $request->input('comments');
        $patient_id = $request->input('patient_id'); // Assuming patient_id is single for all

        if (is_array($service_ids)) {
            $serviceHandler = new \App\Services\ServiceRequestHandler();
            foreach ($service_ids as $index => $service_id) {
                if (!empty($service_id)) {
                    $request_ref = str()->random(6);
                    $comment = isset($comments[$index]) ? $comments[$index] : null;

                    OpticalRequest::create([
                        'patient_id' => $patient_id,
                        'service_id' => $service_id,
                        'comments' => $comment,
                        'ref' => $request_ref,
                        'user_id' => auth()->user()->id,
                        'status' => 'pending'
                    ]);

                    // Generate Billing
                    $serviceItem = Antenatal::find($service_id);
                    if ($serviceItem) {
                        $serviceHandler->handleServiceRequest(
                            $serviceItem->name,
                            $patient_id,
                            'Opticals',
                            'fresh',
                            $request_ref,
                            1,
                            null,
                            'optical_request',
                            'Optical service requested via optical interface by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
                            $serviceItem->id
                        );
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Requests Submitted');
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
    public function destroy(string $id)
    {
        //
    }
}
