@extends('layouts/layoutMaster')

@section('title', 'Antenatal Packages')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
        <span class="text-muted fw-light">Settings /</span> Antenatal Packages
    </h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pkg-modal" id="btn-new-pkg">
        <i class="ti ti-plus me-1"></i> New Package
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
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
                    <td style="max-width:300px;">
                        @if(!empty($pkg->services_covered))
                            @foreach(collect($pkg->services_covered)->groupBy('type') as $type => $items)
                                <div class="small mb-1">
                                    <span class="fw-semibold text-muted text-capitalize">{{ $type }}:</span>
                                    @foreach($items as $s)
                                        <span class="badge bg-label-primary me-1">
                                            {{ $s['name'] }}@if(($s['qty'] ?? 1) > 1) ×{{ $s['qty'] }}@endif
                                        </span>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-icon btn-light me-1 btn-edit"
                            data-pkg="{{ json_encode($pkg) }}"
                            data-bs-toggle="modal" data-bs-target="#pkg-modal" title="Edit">
                            <i class="ti ti-edit"></i>
                        </button>
                        <form action="{{ route('app.antenatal-packages.destroy', $pkg->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Delete this package?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-icon btn-danger" title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No packages yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $packages->links() }}
    </div>
</div>

<!-- Package Modal -->
<div class="modal fade" id="pkg-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pkg-modal-title">New Antenatal Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="pkg-form" method="POST" action="{{ route('app.antenatal-packages.store') }}">
                @csrf
                <span id="method-field"></span>
                <div class="modal-body">

                    {{-- Basic info --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="pkg-name" class="form-control" required placeholder="e.g. Bronze Package">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Price (₦) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="pkg-price" class="form-control" min="0" required placeholder="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" id="pkg-expiry" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" id="pkg-desc" class="form-control" placeholder="Optional...">
                        </div>
                    </div>

                    {{-- Selected services summary --}}
                    <div id="selected-summary" class="border rounded p-2 mb-3 bg-light" style="display:none;">
                        <small class="fw-semibold text-muted d-block mb-2">Selected Services — set allowed quantity:</small>
                        <div id="selected-list" class="row g-2"></div>
                    </div>

                    {{-- Hidden inputs container --}}
                    <div id="hidden-services"></div>

                    {{-- Tabbed service picker --}}
                    <label class="form-label mb-1">Add Services</label>
                    <ul class="nav nav-tabs" id="service-tabs" role="tablist">
                        @foreach($serviceGroups as $type => $group)
                        <li class="nav-item">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                data-bs-toggle="tab" data-bs-target="#tab-{{ $type }}" type="button">
                                {{ $group['label'] }}
                                <span class="badge bg-primary ms-1 tab-count" id="count-{{ $type }}" style="display:none;">0</span>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content border border-top-0 rounded-bottom p-3" style="max-height:240px;overflow-y:auto;">
                        @foreach($serviceGroups as $type => $group)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $type }}">
                            @if($group['items']->isEmpty())
                                <p class="text-muted text-center py-3 mb-0">No {{ $group['label'] }} items found.</p>
                            @else
                                <div class="row g-2">
                                    @foreach($group['items'] as $item)
                                    <div class="col-md-4 col-6">
                                        <div class="form-check">
                                            <input class="form-check-input svc-checkbox"
                                                type="checkbox"
                                                id="svc-{{ $type }}-{{ $item->id }}"
                                                data-type="{{ $type }}"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}">
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
                    <button type="submit" class="btn btn-primary">Save Package</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function () {
    // ── State ──────────────────────────────────────────────
    var selected = {}; // key: "type_id" => {type, id, name, qty}

    // ── Helpers ────────────────────────────────────────────
    function key(type, id) { return type + '_' + id; }

    function renderSummary() {
        var keys = Object.keys(selected);
        if (keys.length === 0) {
            $('#selected-summary').hide();
            return;
        }
        $('#selected-summary').show();

        // Group by type
        var groups = {};
        var typeLabels = {
            consultation: 'Consultation',
            laboratory:   'Laboratory',
            imaging:      'Imaging',
            procedure:    'Procedure',
            pharmacy:     'Pharmacy'
        };

        keys.forEach(function (k) {
            var s = selected[k];
            if (!groups[s.type]) groups[s.type] = [];
            groups[s.type].push(s);
        });

        var html = '';
        Object.keys(groups).forEach(function (type) {
            html += '<div class="col-12 mb-1">' +
                '<small class="fw-semibold text-muted text-uppercase" style="font-size:0.7rem;">' +
                (typeLabels[type] || type) + '</small>' +
                '</div>';

            groups[type].forEach(function (s) {
                var k = key(s.type, s.id);
                html += '<div class="col-md-4 col-6">' +
                    '<div class="input-group input-group-sm">' +
                    '<span class="input-group-text small text-truncate" style="max-width:130px;" title="' + s.name + '">' + s.name + '</span>' +
                    '<input type="number" class="form-control qty-input" min="1" value="' + s.qty + '" data-key="' + k + '" placeholder="Qty">' +
                    '<button type="button" class="btn btn-outline-danger btn-remove" data-key="' + k + '"><i class="ti ti-x"></i></button>' +
                    '</div></div>';
            });

            // spacer between groups
            html += '<div class="col-12 mb-1"></div>';
        });

        $('#selected-list').html(html);
        renderHidden();
        updateCounts();
    }

    function renderHidden() {
        var html = '';
        var i = 0;
        Object.values(selected).forEach(function (s) {
            html += '<input type="hidden" name="service_type[]" value="' + s.type + '">';
            html += '<input type="hidden" name="service_id[]" value="' + s.id + '">';
            html += '<input type="hidden" name="service_name[]" value="' + s.name + '">';
            html += '<input type="hidden" name="service_qty[]" value="' + s.qty + '">';
            i++;
        });
        $('#hidden-services').html(html);
    }

    function updateCounts() {
        var counts = {};
        Object.values(selected).forEach(function (s) {
            counts[s.type] = (counts[s.type] || 0) + 1;
        });
        $('.tab-count').each(function () {
            var type = $(this).attr('id').replace('count-', '');
            var c = counts[type] || 0;
            $(this).text(c).toggle(c > 0);
        });
    }

    function resetModal() {
        selected = {};
        $('#pkg-form')[0].reset();
        $('#selected-list').html('');
        $('#selected-summary').hide();
        $('#hidden-services').html('');
        $('.svc-checkbox').prop('checked', false);
        updateCounts();
    }

    // ── New package button ─────────────────────────────────
    $('#btn-new-pkg').on('click', function () {
        resetModal();
        $('#pkg-modal-title').text('New Antenatal Package');
        $('#pkg-form').attr('action', '{{ route('app.antenatal-packages.store') }}');
        $('#method-field').html('');
    });

    // ── Edit button ────────────────────────────────────────
    $(document).on('click', '.btn-edit', function () {
        resetModal();
        var pkg = $(this).data('pkg');
        $('#pkg-modal-title').text('Edit Package');
        $('#pkg-form').attr('action', '{{ url('app/antenatal-packages') }}/' + pkg.id);
        $('#method-field').html('<input type="hidden" name="_method" value="PUT">');

        $('#pkg-name').val(pkg.name);
        $('#pkg-price').val(pkg.price);
        $('#pkg-expiry').val(pkg.expiry_date ? pkg.expiry_date.substring(0, 10) : '');
        $('#pkg-desc').val(pkg.description || '');

        // Restore selected services
        if (pkg.services_covered) {
            pkg.services_covered.forEach(function (s) {
                var k = key(s.type, s.id);
                selected[k] = { type: s.type, id: s.id, name: s.name, qty: s.qty || 1 };
                $('#svc-' + s.type + '-' + s.id).prop('checked', true);
            });
        }
        renderSummary();
    });

    // ── Checkbox toggle ────────────────────────────────────
    $(document).on('change', '.svc-checkbox', function () {
        var type = $(this).data('type');
        var id   = $(this).data('id');
        var name = $(this).data('name');
        var k    = key(type, id);

        if ($(this).is(':checked')) {
            selected[k] = { type: type, id: id, name: name, qty: 1 };
        } else {
            delete selected[k];
        }
        renderSummary();
    });

    // ── Qty change ─────────────────────────────────────────
    $(document).on('change', '.qty-input', function () {
        var k = $(this).data('key');
        if (selected[k]) {
            selected[k].qty = Math.max(1, parseInt($(this).val()) || 1);
            renderHidden();
        }
    });

    // ── Remove from summary ────────────────────────────────
    $(document).on('click', '.btn-remove', function () {
        var k = $(this).data('key');
        if (selected[k]) {
            $('#svc-' + selected[k].type + '-' + selected[k].id).prop('checked', false);
            delete selected[k];
        }
        renderSummary();
    });
});
</script>
@endsection
