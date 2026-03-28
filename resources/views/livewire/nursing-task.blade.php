<div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Task</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($tasks as $item)
                <tr>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                    <td class="text-wrap" style="max-width: 400px;">{{ $item->task }}</td>
                    <td>
                        <button wire:click="toggleStatus({{ $item->id }})" class="btn btn-sm btn-{{ $item->status == 'Completed' ? 'success' : 'warning' }}">
                            {{ $item->status }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No nursing tasks found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tasks->links() }}
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="new-nursing-task-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Nursing Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Task Description</label>
                                <textarea wire:model="task" class="form-control" rows="4" placeholder="Enter task details..."></textarea>
                                @error('task') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', () => {
        window.livewire.on('closeModal', () => {
            $('#new-nursing-task-modal').modal('hide');
        });
    });
</script>
    });
</script>
