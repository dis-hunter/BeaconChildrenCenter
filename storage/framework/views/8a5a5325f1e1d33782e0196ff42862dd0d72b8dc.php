
<?php $__env->startSection('title','Login'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015 = $component; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="d-flex justify-content-start align-items-start" style="position: absolute; top: 40px; left: 40px;">
  <a class="btn btn-close btn-md" href="<?php echo e(route('home')); ?>"></a>
</div>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="d-flex justify-content-center">
                  <img src="<?php echo e(asset('images/logo.jpg')); ?>"
                    style="width: 100px;" alt="logo">
                 
                </div>

                <form action="<?php echo e(route('login')); ?>" method="post">
                  <?php echo csrf_field(); ?>

                  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation-errors','data' => ['class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                  <?php if(session('status')): ?>
                    <div class="mb-4 font-medium text-sm text-green-600">
                        <?php echo e(session('status')); ?>

                    </div>
                  <?php endif; ?>

                  <p class="mb-2">Please login to your account</p>
                

                  <div data-mdb-input-init class="form-floating form-outline mb-4">
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>" placeholder="Email" required autofocus autocomplete="username"/>
                    <label class="form-label" for="email_login">Email</label>
                  </div>

                  <div data-mdb-input-init class="form-floating form-outline mb-4">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="current-password" />
                    <i class="bi bi-eye-slash" id="toggleLoginPassword" style="transform: scale(1.2);"></i>
                    <label class="form-label" for="password">Password</label>
                    <script>
                      document.addEventListener('DOMContentLoaded',()=>{
                        const togglePassword= document.querySelector('#toggleLoginPassword');
                        const password=document.querySelector('#password');
                        togglePassword.addEventListener('click',(e)=>{
                            const type = password.getAttribute('type')==='password' ? 'text' : 'password';
                            password.setAttribute('type',type);
                            e.target.classList.toggle('bi-eye');
                        });
                    });
                    </script>
                  </div>

                  <div class="block mt-4 mb-3">
                    <label for="remember_me" class="flex items-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.checkbox','data' => ['id' => 'remember_me','name' => 'remember']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'remember_me','name' => 'remember']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <span class="ml-2 text-sm text-gray-600"><?php echo e(__('Remember me')); ?></span>
                    </label>
                </div>


                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" style="width:100%">Log
                      in</button>
                      <div class="flex items-center justify-end mt-1">
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>">
                                <?php echo e(__('Forgot your password?')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                  </div>
                  

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a href="<?php echo e(route('register')); ?>">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button></a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">We are more than just a hospital</h4>
                <p class="small mb-0">Your health. Our priority. Beacon Children Center. Where healing begins.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-2\resources\views/auth/login.blade.php ENDPATH**/ ?>