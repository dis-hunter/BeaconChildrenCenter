<div class="d-flex align-items-center" id="child-search-bar">
    <!-- Search Input -->
    <input wire:model="search" type="search" class="form-control" placeholder="Search for a child" aria-label="Search">

    <!-- Results Display -->
    <?php if(!empty($results)): ?>
        <ul wire:ignore style="color: black; list-style-type: none; padding: 0;">
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="result-item <?php echo e($loop->index % 2 == 0 ? 'light-gray' : 'white'); ?> py-2 px-3" style="border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                    <section class="row">
                        <div>
                            <li style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div style="flex: 1;">
                                    <input style="display:none;;" ></input>
                                    <strong>Child Name:</strong> 
                                    <?php echo e(json_decode($result->fullname)->first_name ?? 'N/A'); ?> 
                                    <?php echo e(json_decode($result->fullname)->middle_name ?? ''); ?> 
                                    <?php echo e(json_decode($result->fullname)->last_name ?? 'N/A'); ?> 
                                    <br>
                                    <strong>Date of Birth:</strong> <?php echo e($result->dob); ?>

                                    <br>
                                    <strong>Parent Name:</strong> 
                                    <?php echo e(json_decode($result->parent_fullname)->first_name ?? 'N/A'); ?> 
                                    <?php echo e(json_decode($result->parent_fullname)->middle_name ?? 'N/A'); ?> 
                                    <?php echo e(json_decode($result->parent_fullname)->last_name ?? 'N/A'); ?>

                                    <br>
                                    <strong>Parent Email:</strong> <?php echo e($result->email); ?>

                                    <br>
                                    <strong>Parent Phone:</strong> <?php echo e($result->telephone ?? 'Not available'); ?>

                                    <br>
                                </div>
                                <div style="margin-left: 20px;">
                                    <!-- Checkboxes for selection -->
                                    <label class="checkbox-container">
                                        <input type="checkbox" wire:model="selectedItems" value="<?php echo e($result->id); ?>" id="child_id" />
                                        
                                        <span class="checkmark"></span> Select
                                    </label>
                                </div>
                            </li>
                        </div>
                    </section>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/livewire/child-search-bar.blade.php ENDPATH**/ ?>