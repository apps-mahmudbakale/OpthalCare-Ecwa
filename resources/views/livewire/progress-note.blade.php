<div class="mt-3">
    {{-- Timeline Notes --}}
    @forelse($notes as $item)
    <div class="d-flex mb-4">
        {{-- Avatar --}}
        <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
                <span class="avatar-initial rounded-circle bg-label-primary" style="width:38px;height:38px;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:.85rem;">
                    {{ strtoupper(substr($item->user->firstname, 0, 1)) }}{{ strtoupper(substr($item->user->lastname, 0, 1)) }}
                </span>
            </div>
        </div>
        {{-- Card --}}
        <div class="flex-grow-1">
            <div class="card shadow-sm border-0" style="border-left: 3px solid #696cff !important; background:#fff !important;">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-semibold" style="color:#566a7f !important;">
                            {{ $item->user->firstname }} {{ $item->user->lastname }}
                        </span>
                        <small style="color:#a1acb8 !important;">
                            <i class="bx bx-time-five me-1"></i>
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                    <p class="mb-0" style="white-space: pre-wrap; color:#566a7f !important;">{{ $item->note }}</p>
                </div>
            </div>
            {{-- Connector line (except last) --}}
            @if(!$loop->last)
            <div style="border-left: 2px dashed #d9dbe0; height: 16px; margin-left: 11px;"></div>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-4">
        <i class="bx bx-note fs-1 d-block mb-2"></i>
        No progress notes recorded yet.
    </div>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-2">
        {{ $notes->links() }}
    </div>

    {{-- Modal --}}
    <div wire:ignore.self class="modal fade" id="new-progress-note-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Progress Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Note</label>
                                <textarea wire:model="note" class="form-control" rows="10" placeholder="Enter progress note..."></textarea>
                                @error('note') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1" role="status"></span>
                            Save Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', () => {
        window.livewire.on('closeModal', () => {
            $('#new-progress-note-modal').modal('hide');
        });
    });
</script>
