<div>
    <div class="card-header d-flex align-items-center justify-content-between gap-2 pb-2">
        <div class="d-flex align-items-center gap-2">
            <label class="mb-0 text-nowrap small">Show</label>
            <select wire:model="perPage" class="form-select form-select-sm w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="small text-nowrap">entries</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <input type="search" class="form-control form-control-sm" wire:model.debounce.300ms="search"
                   placeholder="Search plans…" style="min-width: 200px;">
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <table id="hmos" class="table table-striped table-responsive dataTable no-footer"
                    role="grid" aria-describedby="users_info">
                    <thead>
                        <tr role="row">
                            <th>S/N</th>
                            <th>Plan Name</th>
                            <th>HMO</th>
                            <th>Enrollment Amount</th>
                            <th>Signup Amount</th>
                            <th>Max Members</th>
                            <th>Insurance?</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($plans as $plan)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$plan->name}}</td>
                            <td>{{$plan->hmo->name ?? ''}}</td>
                            <td>{{ number_format($plan->enrollment_amount, 2) }}</td>
                            <td>{{ number_format($plan->signup_amount, 2) }}</td>
                            <td>{{ $plan->max_no ?? 'Unlimited' }}</td>
                            <td>
                                @if($plan->is_insurance)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" id="add-payment-method" data-request-url="{{ route('app.hmo-plans.edit', $plan->id) }}">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" id="add-payment-method" data-request-url="{{ route('app.hmo-plans.services.index', $plan->id) }}">
                                                Services
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" id="add-payment-method" data-request-url="{{ route('app.hmo-plans.services.create', $plan->id) }}">
                                                Add Service
                                            </a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li>
                                            <button class="dropdown-item text-danger" id="del{{ $plan->id }}" data-value="{{ $plan->id }}">
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <script>
                                    document.querySelector('#del{{ $plan->id }}').addEventListener('click', function(e) {
                                        // alert(this.getAttribute('data-value'));
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "You won't be able to revert this!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes, delete it!',
                                            customClass: {
                                                confirmButton: 'btn btn-primary me-3',
                                                cancelButton: 'btn btn-label-secondary'
                                            },
                                            buttonsStyling: false
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('del#'+this.getAttribute('data-value')).submit();
                                                // Swal.fire(
                                                //     'Deleted!',
                                                //     'Your file has been deleted.',
                                                //     'success'
                                                // )
                                            }
                                        })
                                    })
                                </script>
                                <form id="del#{{ $plan->id }}"
                                    action="{{ route('app.hmo-plans.destroy', $plan->id) }}" method="POST"
                                     style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </td>
                        </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between px-3 py-2">
        <p class="text-muted small mb-0">
            Showing <b>{{ $plans->firstItem() }}</b> to <b>{{ $plans->lastItem() }}</b> of <b>{{ $plans->total() }}</b> entries
        </p>
        <div>{{ $plans->links() }}</div>
    </div>
    <script>
    window.addEventListener('HmoPlanEditModal', function() {
        $('#edit-plan-modal').modal('show');
    });
    window.addEventListener('close-modal', function(event) {
        $('#' + event.detail.id).modal('hide');
    });
    </script>
</div>
