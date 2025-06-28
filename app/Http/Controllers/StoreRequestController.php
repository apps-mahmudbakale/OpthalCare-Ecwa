<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugRequest;
use App\Models\StoreRequest;
use Illuminate\Http\Request;

class StoreRequestController extends Controller
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
      return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request_ref = str()->random(6);
      $validated = $request->validate([
        'store_id' => 'required|array',
        'category_id' => 'required|array',
        'drug_id' => 'required|array',
        'qty' => 'required|array',
        'store_id.*' => 'required|exists:drug_stores,id',
        'category_id.*' => 'required|exists:drug_categories,id',
        'drug_id.*' => 'required|exists:drugs,id',
        'qty.*' => 'required|integer|min:1',
      ]);

      $count = count($request->store_id);

      for ($i = 0; $i < $count; $i++) {
        StoreRequest::create([
          'store_id'    => $request->store_id[$i],
          'category_id' => $request->category_id[$i],
          'drug_id'     => $request->drug_id[$i],
          'qty'         => $request->qty[$i],
          'user_id'     => auth()->id(),
          'ref' => $request_ref, // Optional: if you track user
        ]);
      }

      return redirect()->route('app.pharmacy.index')->with('success', 'Drug request(s) submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $requests = StoreRequest::with(['user', 'store', 'drug', 'category'])
        ->where('ref', $id)
        ->get()
        ->filter(fn($item) => is_object($item));

      return view('store.details', compact('requests'));
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
//      dd(request()->all());

      for ($i = 0; $i < count($request->drug_id); $i++) {
        // Find the specific store request to update
        $storeRequest = StoreRequest::where([
          'drug_id' => $request->drug_id[$i],
          'store_id' => $request->store_id[$i],
          'qty' => $request->qty[$i], // optional if multiple same records exist
          'ref' => $request->ref
        ])->first();

        if ($storeRequest) {
          $drug = Drug::find($request->drug_id[$i]);
          if ($drug && $drug->quantity >= $request->qty[$i]) {
            $drug->quantity -= $request->qty[$i];
            $drug->dispense_qty = $request->qty[$i];
            $drug->save();
          }
          $storeRequest->status = 'approved'; // Set status if needed
          $storeRequest->save();

          // Optionally reduce drug stock
        }
      }

      return redirect()->back()->with('success', 'Request(s) approved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
