<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/lux/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('css/navbar-fixed-left.min.css')); ?>">
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
  
  <script async defer src="https://buttons.github.io/buttons.js"></script>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-left" id="mainNav">

    <a class="navbar-brand ml-4" href><?php echo e(config('app.name')); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-3" id="navbarsExampleDefault">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">Contact</a>
            </li>
            <?php if(auth()->guard()->check()): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item">Action</a>
                    <a class="dropdown-item">Another action</a>
                    <a class="dropdown-item">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item">Separated link</a>
                    <a class="dropdown-item">One more separated link</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-class="fixed-left">
                    <i class="fa fa-arrow-left"></i>
                    Fixed Left
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-class="fixed-top">
                    <i class="fa fa-arrow-up"></i>
                    Fixed Top
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-class="fixed-right">
                    <i class="fa fa-arrow-right"></i>
                    Fixed Right
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- User Dropdown Menu at Top-Right -->
    
</nav>
<nav class="navbar navbar-expand-md responsive-navbar" id="Account"> 
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
                    <a class="dropdown-item" href="<?php echo e(route('profile')); ?>">Profile</a>
                    <?php else: ?>
                    <a class="dropdown-item" href="<?php echo e(route('login')); ?>">Login</a>
                    <a class="dropdown-item" href="<?php echo e(route('register')); ?>">Register</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </div>
    </nav><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/header.blade.php ENDPATH**/ ?>