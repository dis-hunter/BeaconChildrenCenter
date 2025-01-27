<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/lux/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('css/navbar-fixed-left.min.css')); ?>">

<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
  
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <?php echo \Livewire\Livewire::styles(); ?>


<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-left" id="mainNav">

    <a class="navbar-brand ml-4" href>Reception</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-3" id="navbarsExampleDefault">
        <ul class="navbar-nav">
            <?php if(auth()->guard()->check()): ?>
            <li class="nav-item">
                <a href="/dashboard" class="nav-link"><span class="icon">〰️</span> <span class="text">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="/patients" class="nav-link"><span class="icon">🚑</span> <span class="text">Patients</span></a>
            </li>
            <li class="nav-item">
                <a href="/guardians" class="nav-link"><span class="icon">➕</span> <span class="text">Guardians</span></a>
            </li>
            <li class="nav-item">
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 35ebdb2fdc66a4507a02e8bbf537f8e133c98ffe
                <a href="<?php echo e(route('reception.calendar')); ?>" class="nav-link">
                    <span class="icon">📅</span>
                    <span class="text">Appointments</span>
                </a>
<<<<<<< HEAD
                
=======
                <a href="#" class="nav-link"><span class="icon">📖</span> <span class="text">Appointments</span></a>
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499
=======
>>>>>>> 35ebdb2fdc66a4507a02e8bbf537f8e133c98ffe
            </li>


            <li class="nav-item">
                <a href="/visithandle" class="nav-link"><span class="icon">🕒</span> <span class="text">Visit</span></a>
            </li>
<<<<<<< HEAD
<<<<<<< HEAD
           
=======
=======

>>>>>>> 35ebdb2fdc66a4507a02e8bbf537f8e133c98ffe
            <li class="nav-item">
                <a href="/get-invoices" class="nav-link"><span class="icon">🕒</span> <span class="text">Invoices</span></a>
            </li>
<<<<<<< HEAD
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499
=======
           
>>>>>>> 35ebdb2fdc66a4507a02e8bbf537f8e133c98ffe
            
            
            
        </ul>
        
        <?php endif; ?>
    </div>

    <!-- User Dropdown Menu at Top-Right -->
    
</nav>
<nav class="navbar navbar-expand-md responsive-navbar" id="Account">
    <div class="global-search"><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-search')->html();
<<<<<<< HEAD
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('ulLeNa3')) {
    $componentId = $_instance->getRenderedChildComponentId('ulLeNa3');
    $componentTag = $_instance->getRenderedChildComponentTagName('ulLeNa3');
=======
} elseif ($_instance->childHasBeenRendered('xG7yNqA')) {
    $componentId = $_instance->getRenderedChildComponentId('xG7yNqA');
    $componentTag = $_instance->getRenderedChildComponentTagName('xG7yNqA');
>>>>>>> 35ebdb2fdc66a4507a02e8bbf537f8e133c98ffe
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('xG7yNqA');
} else {
    $response = \Livewire\Livewire::mount('global-search');
    $html = $response->html();
<<<<<<< HEAD
    $_instance->logRenderedChild('ulLeNa3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
} elseif ($_instance->childHasBeenRendered('lM8BYjC')) {
    $componentId = $_instance->getRenderedChildComponentId('lM8BYjC');
    $componentTag = $_instance->getRenderedChildComponentTagName('lM8BYjC');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lM8BYjC');
} else {
    $response = \Livewire\Livewire::mount('global-search');
    $html = $response->html();
    $_instance->logRenderedChild('lM8BYjC', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>> b335664e68a5fed68c943394e1f74d79f1992499
=======
    $_instance->logRenderedChild('xG7yNqA', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>> 35ebdb2fdc66a4507a02e8bbf537f8e133c98ffe
}
echo $html;
?></div> 
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

        <div id="calendar-section" class="col-md-9 p-4" style="display: none;">
            <!-- Calendar will be displayed here dynamically -->
        </div>
    </div>
    </nav>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarSection = document.getElementById('calendar-section');
    const sidebarLinks = document.querySelectorAll('.load-section');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const section = this.getAttribute('data-section');

            if (section === 'calendar-section') {
                // Fetch calendar content (if not already loaded)
                if (!calendarSection.innerHTML.trim()) {
                    fetch('/calendar')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to load calendar');
                            }
                            return response.text();
                        })
                        .then(html => {
                            calendarSection.innerHTML = html;
                            calendarSection.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            calendarSection.innerHTML = '<p class="text-danger">Failed to load calendar.</p>';
                            calendarSection.style.display = 'block';
                        });
                } else {
                    calendarSection.style.display = 'block';
                }
            } else {
                // Hide the calendar section for other links
                calendarSection.style.display = 'none';
            }
        });
    });
});

</script>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/header.blade.php ENDPATH**/ ?>