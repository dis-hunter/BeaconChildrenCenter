<div>
    
    <div class="modal fade" id="editChildModal" tabindex="-1" aria-labelledby="editChildModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editChildModalLabel">Edit Child Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="childName" class="form-label">Child Name</label>
                            <input type="text" class="form-control" id="childName" name="childName" required>
                        </div>
                        <div class="mb-3">
                            <label for="childAge" class="form-label">Age</label>
                            <input type="number" class="form-control" id="childAge" name="childAge" required>
                        </div>
                        <div class="mb-3">
                            <label for="childNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="childNotes" name="childNotes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/edit-child-modal.blade.php ENDPATH**/ ?>