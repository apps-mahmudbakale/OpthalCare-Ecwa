<div>
    <div class="card-header border-bottom d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0">Antenatal Packages</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pkg-modal"
            wire:click="openCreate">
            <i class="ti ti-plus me-1"></i> New Package
        </button>
    </div>

    <div class="card-header border-bottom d-flex align-items-center justify-content-between py-2">
        <div class="d-flex align-items-center">
            <label class="me-2 mb-0">Show</label>
            <select class="form-select form-select-sm w-auto" wire:model="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Search..."
            wire:model.debounce.300ms="search">
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price (₦)</th>
                    <th>Expiry</th>
                    <th>Services Covered</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $pkg)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold">{{ $pkg->name }}</div>
                        @if($pkg->description)
                            <small class="text-muted">{{ $pkg->description }}</small>
                        @endif
                    </td>
                    <td>₦{{ number_format($pkg->price) }}</td>
                    <td>
                        @if($pkg->expiry_date)
                            <span class="badge {{ $pkg->expiry_date->isPast() ? 'bg-label-danger' : 'bg-label-success' }}">
                                {{ $pkg->expiry_date->format('d M Y') }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td style="max-width:280px;">
                        @if(!empty($pkg->services_covered))
                            @foreach(collect($pkg->services_covered)->groupBy('type') as $type => $items)
                                <div class="small mb-1">
                                    <span class="fw-semibold text-capitalize text-muted">{{ $type }}:</span>
                                    @foreach($items as $s)
                                        <span class="badge bg-label-primary me-1">{{ $s['name'] }} @if(($s['qty'] ?? 1) > 1) ×{{ $s['qty'] }} @endif</span>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-icon btn-light me-1"
                            wire:click="openEdit({{ $pkg->id }})" title="Edit">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-danger"
                            wire:click="delete({{ $pkg->id }})"
                            onclick="return confirm('Delete this package?')" title="Delete">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No packages yet. Add one above.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer border-top py-2">
        {{ $packages->links('vendor.livewire.livewire-vuexy') }}
    </div>

    <!-- Package Modal -->
    <div wire:ignore.self class="modal fade" id="pkg-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Antenatal Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- Basic info --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pkgName') is-invalid @enderror"
                                wire:model="pkgName" placeholder="e.g. Bronze Package">
                            @error('pkgName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price (₦) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('pkgPrice') is-invalid @enderror"
                                wire:model="pkgPrice" min="0" placeholder="0">
                            @error('pkgPrice') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" class="form-control @error('pkgExpiry') is-invalid @enderror"
                                wire:model="pkgExpiry">
                            @error('pkgExpiry') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" wire:model="pkgDescription"
                                placeholder="Optional...">
                        </div>
                    </div>

                    {{-- Selected summary with qty --}}
                    @if(!empty($selectedServices))
                    <div class="border rounded p-2 mb-3 bg-light">
                        <small class="fw-semibold text-muted d-block mb-2">Selected Services — set allowed quantity per service:</small>
                        <div class="row g-2">
                            @foreach($selectedServices as $i => $s)
                            <div class="col-md-4 col-6" wire:key="sel-{{ $s['type'] }}-{{ $s['id'] }}">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text text-capitalize small" style="max-width:140px; overflow:hidden; white-space:nowrap;">
                                        {{ $s['name'] }}
                                    </span>
                                    <input type="number" class="form-control" min="1"
                                        value="{{ $s['qty'] ?? 1 }}"
                                        wire:change="updateQty('{{ $s['type'] }}', {{ $s['id'] }}, $event.target.value)"
                                        placeholder="Qty">
                                    <button type="button" class="btn btn-outline-danger"
                                        wire:click="toggleService('{{ $s['type'] }}', {{ $s['id'] }}, '{{ addslashes($s['name']) }}')">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Tabbed service picker --}}
                    <label class="form-label">Add Services</label>
                    <ul class="nav nav-tabs mb-0" role="tablist">
                        @foreach($serviceGroups as $type => $group)
                        <li class="nav-item">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                data-bs-toggle="tab" data-bs-target="#tab-{{ $type }}" type="button">
                                <i class="ti {{ $group['icon'] }} me-1"></i>{{ $group['label'] }}
                                @php $cnt = collect($selectedServices)->where('type', $type)->count() @endphp
                                @if($cnt) <span class="badge bg-primary ms-1">{{ $cnt }}</span> @endif
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content border border-top-0 rounded-bottom p-2" style="max-height:220px;overflow-y:auto;">
                        @foreach($serviceGroups as $type => $group)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $type }}">
                            @if($group['items']->isEmpty())
                                <p class="text-muted text-center py-3 mb-0">No {{ $group['label'] }} items found.</p>
                            @else
                                <div class="row g-1 pt-1">
                                    @foreach($group['items'] as $item)
                                    <div class="col-md-4 col-6" wire:key="item-{{ $type }}-{{ $item->id }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="svc-{{ $type }}-{{ $item->id }}"
                                                wire:click="toggleService('{{ $type }}', {{ $item->id }}, '{{ addslashes($item->name) }}')"
                                                @if($this->isSelected($type, $item->id)) checked @endif>
                                            <label class="form-check-label small" for="svc-{{ $type }}-{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="save">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                        Save Package
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            window.addEventListener('open-pkg-modal', function () {
                var el = document.getElementById('pkg-modal');
                if (!el) return;
                (bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el)).show();
            });
            window.addEventListener('close-pkg-modal', function () {
                var el = document.getElementById('pkg-modal');
                if (!el) return;
                var m = bootstrap.Modal.getInstance(el);
                if (m) m.hide();
            });
        })();
    </script>
</div>
