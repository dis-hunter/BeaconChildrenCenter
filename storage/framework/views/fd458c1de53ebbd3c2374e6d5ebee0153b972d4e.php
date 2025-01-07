<div>
    
    <!-- Search Parent Form -->

    <div class="row d-flex justify-content-center search-section">
        <!-- Search Label -->
        <div class="col-lg-1 col-md-2 col-sm-1 p-2 d-flex justify-content-center align-items-center search-label">
            <span class="text-primary">Search</span>
        </div>
    
        <!-- Search Input -->
        <div class="col-lg-5 col-md-5 col-sm-10 p-2">
            <input type="text" wire:model.debounce.300ms="query" class="form-control search-input" placeholder="Enter search term">
            <?php $__errorArgs = ['query'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <span class="text-danger error-message"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
    
    <!-- Search Results -->
    <?php if($query && count($parents) > 0): ?>
    <div class="mt-4">
        <div class="card card-body search-results">
            <h5 class="results-header"><?php echo e(count($parents)); ?> Search Results</h5>
            <div>
            <div>

                <div>
                    <div class="table-result">
                        <span>Name</span>
                        <span>Phone</span>
                        <span>Email</span>
                        <span>National ID</span>
                    </div>
                </div>
            </div>
        </div>
            
                <ul class="results-list">
                    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="result-item">
                            <a href="search/<?php echo e($parent->id); ?>" class="result-link">
                                <?php
                                    $fullname=json_decode($parent->fullname,true);
                                ?>
                                <span class="result-title"><?php echo e($fullname['first_name'] .' '. $fullname['last_name']); ?></span>
                                <span class="result-title"><?php echo e($parent->telephone); ?></span>
                                <span class="result-title"><?php echo e($parent->email); ?></span>
                                <span class="result-title"><?php echo e($parent->national_id); ?></span>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php elseif($query): ?>
                <p class="no-results">No results found.</p>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/livewire/child-parent-manager.blade.php ENDPATH**/ ?>