
<?php $__env->startSection('title', 'Register'); ?>
<?php $__env->startSection('content'); ?>
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="card-body p-md-5 mx-md-4">

                        <div class="text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp" style="width: 185px;" alt="logo">
                            <h4 class="mt-1 mb-5 pb-1">Beacon Children Center</h4>
                        </div>

                        <form action="/register" method="post">
                            <?php echo csrf_field(); ?>
                            <p class="mb-4">Register your Staff Account</p>
                            <?php if($errors->any()): ?>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>
                                    <?php echo e($error); ?>

                                </div>
                            </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>
                                    <?php echo e(session('error')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(session()->has('success')): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <div>
                                    <?php echo e(session('success')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" required />
                                        <label for="firstname">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name" required />
                                        <label for="middlename">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" required />
                                        <label for="lastname">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" name="gender" id="gender">
                                            <option selected></option>
                                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($gender->gender); ?>"><?php echo e($gender->gender); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <label for="gender">Gender</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" name="role" id="role">
                                            <option selected></option>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->role); ?>"><?php echo e($role->role); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <label for="role">Role</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="email" id="email_register" name="email" class="form-control" placeholder="Email" required />
                                        <label for="email_register">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" required />
                                        <label for="phone">Phone Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" id="password_register" name="password" class="form-control" placeholder="Password" required />
                                        <label for="password_register">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" required />
                                        <label for="confirmpassword">Confirm Password</label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center pt-1 mb-5 pb-1">
                                <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" style="width:100%">Register</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-center pb-4">
                                <p class="mb-0 me-2">Already have an account?</p>
                                <a href="/login">
                                    <button type="button" class="btn btn-outline-danger">Log in</button>
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/register.blade.php ENDPATH**/ ?>