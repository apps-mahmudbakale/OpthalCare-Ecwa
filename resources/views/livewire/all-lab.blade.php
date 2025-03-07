 <!-- .card-header -->
 <div class="card-header">
     <input type="text" placeholder="search" class="form-control">
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
                 <th>Lab Test</th>
                 <th>Requester</th>
                 <th>Status</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             <!-- tr -->

             @foreach ($labRequests as $labRequest)
                 <tr>

                     <td class="align-middle">{{ $labRequest->test->created_at->diffForHumans() }}</td>
                     <td class="align-middle">
                         <a href="patients/{{ $labRequest->patient->id }}" target="_blank">
                             {{ $labRequest->patient->user->firstname }} {{ $labRequest->patient->user->lastname }}
                         </a>
                     </td>
                     <td class="align-middle">{{ $labRequest->test->name }}</td>
                     <td class="align-middle">{{ $labRequest->user->firstname . ' ' . $labRequest->user->lastname }}
                     </td>
                     <td class="align-middle">{{ $labRequest->status }}</td>

                     <td class="align-middle text-right">
                         <div class="btn-group">
                             <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                 data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                 aria-haspopup="true">
                                 <i class="fa fa-ellipsis-v"></i>
                             </button>
                             <ul class="dropdown-menu" style="">
                                 @if (\App\Models\LabRequest::where('id', $labRequest->id)->first()->status == 'Specimen Collected')
                                     <li><a class="dropdown-item" data-bs-toggle="modal"
                                             data-bs-target="#new-add-lab-result">Add Result</a></li>
                                     <li>
                                     @else
                                     <li><a href="{{ route('app.lab.specimen', $labRequest->id) }}"
                                             class="dropdown-item" href="javascript:void(0);">Receive Specimens</a></li>
                                     <li>
                                 @endif
                                 <hr class="dropdown-divider">
                                 </li>
                                 <l><a class="dropdown-item text-bg-danger" href="javascript:void(0);">Cancel</a></l>
                             </ul>
                         </div>
                         @include('_partials._modals.modal-add-lab-result')
                         {{-- <div class="dropdown">
                             <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"
                                 data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                                 <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                             <div class="dropdown-menu dropdown-menu-right">

                                 <button class="dropdown-item has-outstanding-prepaid" type="button">
                                     Receive Specimens
                                 </button>
                                 <button class="lab-request-action dropdown-item" data-toggle="question"
                                     data-question="Cancel Lab Request?" data-remote="/lab/requests/30985/cancel"
                                     type="button">
                                     Cancel Request
                                 </button>

                             </div>
                         </div> --}}
                     </td>
                 </tr>
             @endforeach

         </tbody><!-- /tbody -->
     </table><!-- /.table -->
     <hr class="my-2">


     <div class="d-flex justify-content-around">

         {{ $labRequests->links() }}

     </div>


 </div><!-- /.table-responsive -->
