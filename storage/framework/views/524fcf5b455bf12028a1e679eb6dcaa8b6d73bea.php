<div class="d-flex align-items-center flex-column" id="child-search-bar">
    <label for="search-bar" style="color: black !important;"> Search </label> 
    <!-- Search Input -->
    <input wire:model="search" type="search" name="search-bar"id="search-bar" class="form-control mb-2" placeholder="Search for a child" aria-label="Search">

    <!-- Results Display -->
    <?php if(!empty($results)): ?>
        <div class="results-container" style="width: 330px !important; max-height:  300px; margin-left:140px !important;overflow-y: auto; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
            <ul wire:ignore style="color: black; list-style-type: none; padding: 0; margin: 0;">
                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="result-item <?php echo e($loop->index % 2 == 0 ? 'light-gray' : 'white'); ?> py-2 px-3" style="border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                        <div style="flex: 1;">
                            <strong>Child Name:</strong> 
                            <?php echo e($result->fullname->first_name ?? 'N/A'); ?> 
                            <?php echo e($result->fullname->middle_name ?? ''); ?> 
                            <?php echo e($result->fullname->last_name ?? 'N/A'); ?> 
                            <br>
                            <strong>Date of Birth:</strong> <?php echo e($result->dob); ?>

                            <br>
                            <strong>Parent Name:</strong> 
                            <?php echo e($result->parent_fullname->first_name ?? 'N/A'); ?> 
                            <?php echo e($result->parent_fullname->middle_name ?? 'N/A'); ?> 
                            <?php echo e($result->parent_fullname->last_name ?? 'N/A'); ?>

                            <br>
                            <strong>Parent Email:</strong> <?php echo e($result->email); ?>

                            <br>
                            <strong>Parent Phone:</strong> <?php echo e($result->telephone ?? 'Not available'); ?>

                        </div>
                        <div >
                            <!-- Checkboxes for selection -->
                            <label class="checkbox-container">
                                <input type="checkbox" wire:model="selectedItems" value="<?php echo e($result->id); ?>" id="child_id_<?php echo e($result->id); ?>" />
                                <span class="checkmark"></span> Select
                            </label>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <br>
    <?php else: ?>
        <p style="color:white; margin-top: 10px;">No results found.</p>
    <?php endif; ?>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/child-search-bar.blade.php ENDPATH**/ ?>