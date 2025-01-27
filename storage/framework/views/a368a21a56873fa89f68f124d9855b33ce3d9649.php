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
<<<<<<< HEAD
                wire:focus="$set('isFocused',true)"
                wire:blur="$set('isFocused',false)"
                style="width: 300px;" 
            />
            </div>
            <div wire:loading.block class="loader"></div>
            <style>
                .loader {
                    height: 5px;
                    width: inherit;
                    --c:no-repeat linear-gradient(#6100ee 0 0);
                    background: var(--c),var(--c),#d7b8fc;
                    background-size: 60% 100%;
                    animation: l16 3s infinite;
                    border-radius: 5px;
                    }
                @keyframes l16 {
                    0%   {background-position:-150% 0,-150% 0}
                    66%  {background-position: 250% 0,-150% 0}
                    100% {background-position: 250% 0, 250% 0}
                    }
            </style>
            
        
    
        <!-- Results Dropdown -->
        <?php if($isFocused && (!empty($query) || !empty($history))): ?>
=======
                style="width: 300px;" 
            />
        </div>
    
        <!-- Results Dropdown -->
        <?php if(!empty($query)): ?>
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499
        <div class="dropdown-menu show w-100 position-absolute mt-1" style="z-index: 1050; max-height: 300px; overflow-y: auto;">
            <button
                type="button"
                class="btn-close position-absolute top-0 end-0 m-2"
                aria-label="Close"
                wire:click="$set('query', '')"
                style="z-index: 1051;"
            ></button>
        
<<<<<<< HEAD
            
            <?php if(empty($query) && !empty($history)): ?>
            <h6 class="dropdown-header">Search History</h6>
            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="dropdown-item">
                    <a href="<?php echo e(route(strtolower($item['model']) . '.search', ['id' => $item['id']])); ?>" class="text-decoration-none">
                        <?php echo e($item['name']); ?>

                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="dropdown-item">
                <button class="btn btn-link text-danger p-0" wire:click="clearHistory">Clear</button>
            </div>
            <?php endif; ?>

            <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <h6 class="dropdown-header"><?php echo e($model); ?></h6>
                <?php if(empty($records)): ?>
=======
            <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <h6 class="dropdown-header"><?php echo e($model); ?></h6>
                <?php if($records->isEmpty()): ?>
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499
                    <div class="dropdown-item text-muted">No <?php echo e(strtolower($model)); ?> found.</div>
                <?php else: ?>
                    <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $route = strtolower($model) . '.search';
                        ?>
                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                            <a href="<?php echo e(route($route, ['id' => $record->id])); ?>" class="text-decoration-none">
<<<<<<< HEAD
                                <?php echo e((($record->fullname?->first_name ?? '').' '.($record->fullname?->middle_name ?? '').' '.($record->fullname?->last_name ?? '')) ?? 'N/A'); ?>
=======
                                <?php echo e((($record->fullname->first_name ?? '').' '.($record->fullname->middle_name ?? '').' '.($record->fullname->last_name ?? '')) ?? 'N/A'); ?>
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499

                            </a>
                            <?php if(strtolower($model) === 'patients'): ?>
                                <a href="<?php echo e(route('search.visit',['id'=>$record->id])); ?>"><button class="btn btn-dark btn-sm">Visit</button></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="dropdown-item text-muted">No results found.</div>
            <?php endif; ?>
        </div>
        
        <?php endif; ?>
    </div>
    
<<<<<<< HEAD
=======
    
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499
</div>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/livewire/global-search.blade.php ENDPATH**/ ?>