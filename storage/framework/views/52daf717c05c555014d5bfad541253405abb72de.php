<div>
    
    <div class="position-relative">
        <div class="input-group" style="border: 1px solid black; border-radius:5px;">
            <span class="input-group-text">
                <i class="fa fa-search"></i>
            </span>
            <input
                type="text"
                class="form-control"
                placeholder="Search..."
                wire:model.debounce.300ms="query"
                style="width: 300px;" 
            />
        </div>
    
        <!-- Results Dropdown -->
        <?php if(!empty($query)): ?>
            <div class="dropdown-menu show w-100 position-absolute mt-1" style="z-index: 1050; max-height: 300px; overflow-y: auto;">
                <button
                type="button"
                class="btn-close position-absolute top-0 end-0 m-2"
                aria-label="Close"
                wire:click="$set('query', '')"
                style="z-index: 1051;"
            ></button>

                <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <h6 class="dropdown-header"><?php echo e($model); ?></h6>
                    <?php if($records->isEmpty()): ?>
                        <div class="dropdown-item text-muted">No <?php echo e(strtolower($model)); ?> found.</div>
                    <?php else: ?>
                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $route=strtolower($model).'.search';
                        ?>
                            <a href="<?php echo e(route($route,['id'=>$record->hash_id])); ?>" class="dropdown-item">
                                <?php echo e((($record->fullname->first_name ?? '').' '.($record->fullname->middle_name ?? '').' '.($record->fullname->last_name ?? '')) ?? 'N/A'); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="dropdown-item text-muted">No results found.</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/global-search.blade.php ENDPATH**/ ?>