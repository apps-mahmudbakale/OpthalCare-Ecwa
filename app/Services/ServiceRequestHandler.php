<?php

namespace App\Services;

use App\Models\Billing;

class ServiceRequestHandler
{
  public function handleServiceRequest($serviceName, $patientId, $serviceCategory)
  {
    // Determine the service type dynamically from the model
    $serviceType = $this->detectServiceType($serviceName);
    // Fetch details based on service type
    $service = $serviceType ? $serviceType::where('name', $serviceName)->first() : null;
    if (!$service) {
      // Handle case when service is not found
      return null;
    }


    // Calculate the cost
    $amount = $this->calculateAmount($serviceType, $service);


    // Create a billing record
    $billing = Billing::create([
      'service' => $serviceCategory . ":" . $serviceName,
      'service_id' => $service->id,
      'user_id' => $patientId,
      'quantity' => 1, // Assuming quantity is always 1 for now
      'amount' => $amount,
      'payer_id' => auth()->user()->id, // Assuming you are using authentication
      'status' => 0, // Assuming initial status is 0
    ]);

    return $billing;
  }

  private function detectServiceType($serviceName)
  {
    // Iterate through the models to find the service type dynamically
    $models = [
      'Speciality' => 'App\Models\Speciality',
      'Drug' => 'App\Models\Drug',
      'Laboratory' => 'App\Models\Laboratory',
      'Radiology' => 'App\Models\Radiology',
      'Procedure' => 'App\Models\Procedure',
      //'Admission' => 'App\Models\Admission',
      // Add similar entries for the other models
    ];

    foreach ($models as $modelName => $modelClass) {
      $model = new $modelClass;
      if ($model->getServiceType() && $model::where('name', $serviceName)->exists()) {
        return $modelClass;
      }
    }

    return null;
  }
  private function calculateAmount($serviceType, $service)
  {
    // If the service type is 'Procedure', calculate the amount based on the sum of three columns
    if ($serviceType == 'App\Models\Procedure') {
      return $service->proceddure_cost + $service->theatre_cost + $service->anasthesia_cost + $service->surgeon_fee;
    }

    // For other service types, return the price directly
    return $service->price;
  }
  public function isBilled($serviceId, $serviceName)
  {
    $billings = Billing::where('service_id', $serviceId)
      ->where('service', $serviceName)
      ->first();
    return $billings->status;
  }
}
