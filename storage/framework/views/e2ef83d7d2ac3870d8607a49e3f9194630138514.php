

<?php $__env->startSection('title','Profile'); ?>
<?php $__env->startSection('content'); ?>
<?php if(auth()->guard()->check()): ?>
<style>
    body {
        margin-left: 200px;
    }
    @media (max-width: 768px) { /* For tablets and smaller screens */
    body {
        margin-left: 0px;
        margin-top: 40px;
    }
}

@media (max-width: 576px) { /* For mobile devices */
    body {
        margin-left: 0; /* Remove left margin for small screens */
        margin-top: 40px;
    }

}

    .paymentAmt {
        color: var(--dark-color);
        font-size: 80px;
    }

    .centered {
        text-align: center;
    }

    .title {
        padding-top: 15px;
        color: var(--dark-color);
    }
</style>
<div class="container">
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="https://png.pngitem.com/pimgs/s/150-1503945_transparent-user-png-default-user-image-png-png.png" class="avatar img-circle" alt="avatar">
                <h6>Upload a different photo...</h6>

                <input type="file" class="form-control">
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            <!-- <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          This is an <strong>.alert</strong>. Use this to show important messages to the user.
        </div> -->
            <h3>Personal info</h3>

            <form class="form-horizontal" role="form">
                <div class="row gx-1">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label">Firstname:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="<?php echo e($user->fullname->first_name ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label">Middlename:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="<?php echo e($user->fullname->middle_name ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label">Lastname:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="<?php echo e($user->fullname->last_name ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row gx-1">
                <div class="form-group col-md-6">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="email" value="<?php echo e($user['email'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Phone Number:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?php echo e($user['telephone']); ?>">
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Staff Number</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?php echo e($user['staff_no']); ?>" disabled>
                    </div>
                </div>
                <div class="row gx-1">
                <div class="form-group col-md-6">
                    <label class="col-lg-3 control-label">Designation:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="email" value="<?php echo e($role ?? ''); ?>" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-lg-3 control-label">Gender:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?php echo e($gender ?? ''); ?>" disabled>
                    </div>
                </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="button" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
<hr>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/profile.blade.php ENDPATH**/ ?>