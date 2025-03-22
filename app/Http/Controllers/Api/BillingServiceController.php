<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\TempPatient;
use Illuminate\Http\Request;

class BillingServiceController extends Controller
{
  public function index(Request $request)
  {
    // Get the category from the request
    $category = $request->input('category');

    // Define the service class to be used
    $class = 'App\Services\BillingService';

    // Check if the class exists
    if (class_exists($class)) {
      $billserviceInstance = app($class); // Create an instance of the class

      // Check if the method exists within the class
      if (method_exists($billserviceInstance, $category)) {
        // Call the method dynamically
        $result = $billserviceInstance->{$category}($category);
        // You might want to return or process the result instead of dumping the request
        return response()->json($result); // Respond with the result as JSON
      } else {
        // Handle case where method does not exist
        return response()->json(['error' => 'Method not found'], 404);
      }
    } else {
      // Handle case where class does not exist
      return response()->json(['error' => 'Service class not found'], 404);
    }
  }

  public function verifyAccessCode($patient, $type, $accessCode)
  {
    if ($type == 'follow-up'){
      $follow = FollowUp::where('access_code', $accessCode)->first();
      if ($follow) {
        return response()->json([
          'success' => true,           // Add a success flag
          'message' => 'Access code verified successfully.',
          'data' => $follow        // Include the patient data in the response
        ]);
      } else {
        return response()->json([
          'success' => false,          // Return failure flag
          'message' => 'Invalid access code. Please try again.' // Return a failure message
        ], 404);  // Optional: return a 404 status code if the access code is not found
      }
    }
    $tempPatient = TempPatient::where('accesscode', $accessCode)->first();

    if ($tempPatient) {
      return response()->json([
        'success' => true,           // Add a success flag
        'message' => 'Access code verified successfully.',
        'data' => $tempPatient        // Include the patient data in the response
      ]);
    } else {
      return response()->json([
        'success' => false,          // Return failure flag
        'message' => 'Invalid access code. Please try again.' // Return a failure message
      ], 404);  // Optional: return a 404 status code if the access code is not found
    }

  }
}
