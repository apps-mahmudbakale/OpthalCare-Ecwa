   <!-- .card-header -->
   <div class="card-header">
       <input type="text" class="form-control" placeholder="search">
   </div><!-- /.card-header -->
   <!-- .table-responsive -->
   <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped">
           <!-- thead -->
           <thead>
               <tr>
                   <th>Date</th>
                   <th>Patient</th>
                   <th>Investigation</th>
                   <th>Requester</th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
               <!-- tr -->
               @foreach ($radiologyRequests as $radiologyRequest)
                   <tr>
                       <td class="align-middle">
                           {{ $radiologyRequest->created_at->diffForHumans() }}
                       </td>
                       <td class="align-middle">
                           <a target="_blank"
                               href="/app/patient/{{ $radiologyRequest->patient->id }}">{{ $radiologyRequest->patient->user->firstname }}
                               {{ $radiologyRequest->patient->user->lastname }}
                               [HRN {{ $radiologyRequest->patient->hospital_no }}]</a>
                       </td>
                       <td class="align-middle">
                           {{ $radiologyRequest->request_note }}
                       </td>
                       <td class="align-middle"> {{ $radiologyRequest->user->firstname }}
                           {{ $radiologyRequest->user->lastname }}</td>
                       <td class="align-middle text-right">
                           <div class="dropdown">
                               <button class="btn btn-sm btn-icon btn-light p-0" type="button" id="topCourses"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   <i class="fa fa-ellipsis-v"></i>
                               </button>
                               <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topCourses" style="">
                                   <button class="dropdown-item" data-toggle="modal"
                                       data-remote="/radiology/requests/26808/notes/add" data-target="#newRequestModal"
                                       type="button">
                                       Add Findings/Notes
                                   </button>

                                   <a class="dropdown-item cancel-request"
                                       wire:click="cancelRequest({{ $radiologyRequest->id }})" type="button"
                                       data-toggle="question" data-question="Cancel Request?">
                                       Cancel Request
                                   </a>
                               </div>
                           </div>

                       </td>
                   </tr>
               @endforeach


           </tbody><!-- /tbody -->
       </table><!-- /.table -->
       <hr class="my-2">


       <div class="d-flex justify-content-around">
           {{ $radiologyRequests->links('shared.custom-pagination') }}
           <input type="hidden" class="sr-only filter" name="page" value="1">

       </div>

   </div>
