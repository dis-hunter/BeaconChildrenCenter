<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/lux/bootstrap.min.css" />
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
  
  <script async defer src="https://buttons.github.io/buttons.js"></script>
<style>
    .navbar-nav {
    display: flex;
    justify-content: center;
    align-items: center;
}

.d-flex.mx-auto {
    flex-grow: 1;
    text-align: center;
}

.nav-item .nav-link {
    padding: 10px 15px;
    color:white;
}

.navbar-toggler {
    border: none;
    outline: none;
}
</style>
<nav class="navbar navbar-expand-md responsive-navbar" id="Account"> 
    <div class="shrink-0 flex items-center ml-5">
        <a href="<?php echo e(route('home')); ?>">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-mark','data' => ['class' => 'block h-9 w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('application-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'block h-9 w-auto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </a>
    </div>

    <button
        class="navbar-toggler mr-4"
        type="button"
        data-toggle="collapse"
        data-target="#navbarContent"
        aria-controls="navbarContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
    <div class="d-flex mx-auto justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('home')); ?>"> Home </a>
            </li>
            <li class="nav-item">
                <a style="color:white;" class="nav-link"> About Us </a>
            </li>
            <li class="nav-item">
                <a style="color:white;"  class="nav-link"> Contact Us </a>
            </li>
    </ul>
</div>
    <div class="ml-auto">
        <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i> 
                <?php if(auth()->guard()->check()): ?>
                <?php echo e(auth()->user()->fullname->first_name ?? ''.' '.auth()->user()->fullname->last_name ?? ''); ?>

                <?php else: ?>
                Account
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <?php if(auth()->guard()->check()): ?>
                <form action="/logout" method="post"><?php echo csrf_field(); ?><button class="dropdown-item" type="submit">Logout</button></form>
                <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">Profile</a>
                <?php else: ?>
                <a class="dropdown-item" href="<?php echo e(route('login')); ?>">Login</a>
                <a class="dropdown-item" href="<?php echo e(route('register')); ?>">Register</a>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</div>
    </div>
    </nav><?php /**PATH C:\Users\User\Hospital\BeaconChildrenCenter\resources\views/header.blade.php ENDPATH**/ ?>