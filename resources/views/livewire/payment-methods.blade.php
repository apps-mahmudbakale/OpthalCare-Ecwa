<div>
    <div id="users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="users_length"><label>Show <select wire:model="perPage"
                            aria-controls="departments"
                            class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> entries</label></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="users_filter" class="dataTables_filter"><label>Search:<input type="search"
                            class="form-control form-control-sm" wire:model.debounce.300ms='search' placeholder=""
                            aria-controls="departments"></label></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="departments" class="table table-striped dataTable no-footer"
                    role="grid" aria-describedby="users_info">
                    <thead>
                        <tr role="row">
                            <th>S/N</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($methods as $method)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$method->name}}</td>
                              <td>
                                <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                                               data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                  <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a  data-request-url="{{ route('app.payments.edit-method', $method->id) }}"
                                           data-toggle="modal" data-target="#global-modal" class="dropdown-item">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href="javascript:void(0);" class="dropdown-item-delete text-danger"
                                           onclick="submitMethodDeleteForm({{ $method->id }})">Delete</a></li>
                                  </ul>
                                </div>
                                <form id="delete-method-{{ $method->id }}"
                                      action="{{ route('app.payments.delete-method') }}"
                                      method="POST"
                                      style="display: none;"
                                      wire:ignore>
                                  <input type="hidden" name="method_id" value="{{$method->id}}">
                                  @csrf
                                </form>
                              </td>
                        </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="users_info" role="status" aria-live="polite">Showing <b>{{ $methods->firstItem() }}</b> to
                    <b>{{ $methods->lastItem() }}</b> out of <b>{{ $methods->total() }}</b> entries</div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="users_paginate">
                    {{ $methods->links() }}
                </div>
            </div>
        </div>
    </div>
  <script>
    function submitMethodDeleteForm(id) {
      if (confirm('Are you sure you want to delete this Payment Method?')) {
        const form = document.getElementById('delete-method-' + id);
        if (form) {
          form.submit();
        }
      }
    }
  </script>
</div>

