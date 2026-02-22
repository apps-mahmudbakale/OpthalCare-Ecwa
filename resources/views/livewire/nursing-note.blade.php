<div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($notes as $item)
                <tr>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                    <td class="text-wrap" style="max-width: 400px;">{{ $item->note }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No nursing notes found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $notes->links() }}
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="new-nursing-note-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Nursing Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Note</label>
                                <textarea wire:model="note" class="form-control" rows="10" placeholder="Enter nursing note..."></textarea>
                                @error('note') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
       @this.on('closeModal', (event) => {
           $('#new-nursing-note-modal').modal('hide');
       });
    });
</script>
