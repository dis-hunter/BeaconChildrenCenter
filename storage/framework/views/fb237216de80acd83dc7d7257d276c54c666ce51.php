<div>
    <?php if($parent): ?>
    
    <div class="container card card-body my-4">
        <!-- Parent Card -->
            <div class="card-header bg-primary text-white">
                <h5>Parent</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Full Name: </strong><?php echo e($parent->fullname->last_name .' '.$parent->fullname->first_name.' '.$parent->fullname->middle_name); ?></div>
                    <div class="col-md-4"><strong>Email: </strong><?php echo e($parent->email); ?></div>
                    <div class="col-md-4"><strong>Phone: </strong><?php echo e($parent->telephone); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>National ID: </strong><?php echo e($parent->national_id); ?></div>
                    <div class="col-md-4"><strong>Employer: </strong><?php echo e($parent->employer); ?></div>
                    <div class="col-md-4"><strong>Insurance: </strong><?php echo e($parent->insurance); ?></div>
                </div>
                <div class="row mb-2 d-flex justify-content-between">
                    <div class="col-md-4"><strong>Relationship: </strong>
                        <?php $__currentLoopData = $relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($item->id === $parent->relationship_id ? $item->relationship : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editParentModal">Edit</button>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('edit-parent-modal',['parent'=>$parent])->html();
} elseif ($_instance->childHasBeenRendered($parent->id)) {
    $componentId = $_instance->getRenderedChildComponentId($parent->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($parent->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($parent->id);
} else {
    $response = \Livewire\Livewire::mount('edit-parent-modal',['parent'=>$parent]);
    $html = $response->html();
    $_instance->logRenderedChild($parent->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
            </div>
        

        <!-- Children Card -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-secondary text-white">
                <h5>Children Details</h5>
            </div>
            <div class="card-body">
                <!-- List of Children -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <?php if(!$children): ?>

                        <div class="card mb-2">                         
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <p>No children related to this Parent</p>
                                </div>
                            </div>
                        </div>

                        <?php else: ?>
                            
                        <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="card mb-2">                         
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"><strong>Child Name:</strong> <?php echo e($item->fullname->last_name.' '.$item->fullname->first_name.' '.$item->fullname->middle_name); ?></div>
                                    <div class="col-md-4"><strong>Date of Birth:</strong> <?php echo e($item->dob); ?></div>
                                    <div class="col-md-4 text-end">
                                        <a href="/patients/<?php echo e($item->id); ?>" class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editChildModal-<?php echo e($item->id); ?>">Edit</button>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('edit-child-modal',['child'=>$item])->html();
} elseif ($_instance->childHasBeenRendered($item->id)) {
    $componentId = $_instance->getRenderedChildComponentId($item->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($item->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($item->id);
} else {
    $response = \Livewire\Livewire::mount('edit-child-modal',['child'=>$item]);
    $html = $response->html();
    $_instance->logRenderedChild($item->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addChildModal">Add Child</button>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('add-child-modal',['parent'=>$parent])->html();
} elseif ($_instance->childHasBeenRendered('l1477797537-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l1477797537-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1477797537-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1477797537-2');
} else {
    $response = \Livewire\Livewire::mount('add-child-modal',['parent'=>$parent]);
    $html = $response->html();
    $_instance->logRenderedChild('l1477797537-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    <?php else: ?>
        
    

    <?php endif; ?>

</div>
</div>
<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/livewire/parent-crud.blade.php ENDPATH**/ ?>