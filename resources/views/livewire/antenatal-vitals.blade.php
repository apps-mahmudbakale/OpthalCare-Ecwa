<div>
    @if($groupedVitals->count() > 0)
        <div class="row">
            @foreach($groupedVitals as $date => $dayVitals)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="ti ti-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                            </h6>
                            <span class="badge bg-primary">{{ $dayVitals->count() }} readings</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($dayVitals as $vital)
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="border rounded p-3 h-100 position-relative">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="text-primary mb-0">{{ $vital->parameter }}</h6>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" 
                                                               onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" 
                                                               wire:click="delete({{ $vital->id }})">
                                                                <i class="ti ti-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <span class="h5 text-dark">{{ $vital->value }}</span>
                                                @if(in_array($vital->parameter, ['Temperature']))
                                                    <small class="text-muted">°C</small>
                                                @elseif(in_array($vital->parameter, ['Weight']))
                                                    <small class="text-muted">kg</small>
                                                @elseif(in_array($vital->parameter, ['Height', 'Fundus Height', 'Head Circumference']))
                                                    <small class="text-muted">cm</small>
                                                @elseif(in_array($vital->parameter, ['Pulse', 'Fetal Heart Rate']))
                                                    <small class="text-muted">bpm</small>
                                                @elseif(in_array($vital->parameter, ['Blood Pressure']))
                                                    <small class="text-muted">mmHg</small>
                                                @elseif(in_array($vital->parameter, ['SpO2']))
                                                    <small class="text-muted">%</small>
                                                @elseif(in_array($vital->parameter, ['Respiration']))
                                                    <small class="text-muted">/min</small>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                <i class="ti ti-clock me-1"></i>
                                                {{ $vital->created_at->format('h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-3">
            {{ $vitals->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="ti ti-activity-heartbeat" style="font-size: 3rem; color: #ddd;"></i>
            </div>
            <h6 class="text-muted">No vital signs recorded</h6>
            <p class="text-muted mb-0">Vital signs will appear here once recorded.</p>
        </div>
    @endif
</div>
