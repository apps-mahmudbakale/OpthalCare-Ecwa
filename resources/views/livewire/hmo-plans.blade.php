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
                            <th>Name</th>
                            <th>HMO</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($plans as $plan)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$plan->hmo->name}}</td>
                            <td>{{$plan->hmo->name}}</td>
                            <td>{{$plan->hmo->phone}}</td>
                            <td>{{$plan->hmo->email}}</td>
                            <td>{{$plan->hmo->address}}</td>
                            <td class="text-right">
                                <span class="dropdown ml-1">
                                    <button class="btn btn-default btn-sm dropdown-toggle align-text-top"
                                        data-boundary="viewport" data-toggle="dropdown">Actions</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="" wire:click.prevent="selectPlan({{ $plan->id }})">
                                            Edit
                                        </a>
                                        <a class="dropdown-item" href="" wire:click.prevent="$emit('manageServices', {{ $plan->id }})">
                                            Services
                                        </a>
                                        <a class="dropdown-item" href="" wire:click.prevent="$emit('manageServices', {{ $plan->id }})">
                                            Add Service
                                        </a>
                                        <button class="dropdown-item" id="del{{ $plan->id }}" data-value="{{ $plan->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </span>
                                <script>
                                    document.querySelector('#del{{ $plan->id }}').addEventListener('click', function(e) {
                                        // alert(this.getAttribute('data-value'));
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "You won't be able to revert this!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, delete it!'
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
    @push('body-scripts')
    @once
    window.addEventListener('HmoPlanEditModal', function() {
        $('#edit-plan-modal').modal('show');
    });
    @endonce
@endpush
@include('_partials._modals.modal-new-HmoPlan')
@include('_partials._modals.modal-edit-HmoPlan')
</div>

