
<?php $__env->startSection('title','Homepage'); ?>

<?php $__env->startSection('content'); ?>

<style>
  body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #007bff, #0056b3); /* Blue gradient background */
    color: #333;
    margin: 0;
    padding: 20px;
    overflow-x: hidden;
  }

  h1 {
    text-align: center;
    color: #fff; /* White text for better contrast */
    margin-bottom: 20px;
    font-size: 3em;
    animation: fadeInDown 1s ease-in-out;
    font-weight: 800;
    
  }

  .subheading {
    text-align: center;
    font-size: 1.5em;
    color: #fff; /* White text for better contrast */
    margin-bottom: 40px;
    animation: fadeInUp 1s ease-in-out;
  }

  .welcome-message {
    text-align: center;
    font-size: 1.2em;
    margin-bottom: 20px;
    color: #fff; /* White text for better contrast */
    animation: fadeIn 1.5s ease-in-out;
  }

  .btn {
    display: inline-block;
    padding: 12px 24px;
    background: #fff; /* White background for buttons */
    color: #007bff; /* Blue text for buttons */
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
    animation: fadeInUp 1s ease-in-out;
  }

  .btn:hover {
    background: black; /* Blue background on hover */
    color:white;
    transform: translateY(-5px);
    border:2px solid white;
   
  }

  .features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 40px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
    border-radius: 12px;
  }

  .feature {
    border: 1px solid #ddd;
    padding: 25px;
    border-radius: 10px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: #fff; /* White background for feature cards */
    animation: fadeIn 1s ease-in-out;
  }

  .feature:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .feature i {
    font-size: 3em;
    color: #007bff;
    margin-bottom: 15px;
    animation: bounce 2s infinite;
  }

  .feature h3 {
    margin-bottom: 15px;
    font-size: 1.5em;
    color: #333;
  }

  .feature p {
    font-size: 1em;
    color: #666;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
      transform: translateY(0);
    }
    40% {
      transform: translateY(-20px);
    }
    60% {
      transform: translateY(-10px);
    }
  }
</style>

<h1>Beacon Children Center</h1>
<p class="subheading">Your Neurodevelopmental Clinic</p>

<?php if(auth()->guard()->check()): ?>
  <p class="welcome-message">Hello, <?php echo e(auth()->user()->fullname->first_name); ?>!</p>
  <div style="text-align: center; margin-top: 30px;">
    <a href="<?php echo e(route(auth()->user()->getDashboardRoute())); ?>" class="btn" style="background-color: #007bff; color: #fff;">My Dashboard</a>
  </div>
<?php endif; ?>

<div class="features">
  <div class="feature">
    <i class="fas fa-user-md"></i>
    <h3>Experienced Professionals</h3>
    <p>The center has a team of experienced professionals.</p>
  </div>
  <div class="feature">
    <i class="fas fa-calendar-check"></i>
    <h3>Easy Appointments</h3>
    <p>Schedule appointments online or by phone with ease.</p>
  </div>
  <div class="feature">
    <i class="fas fa-heartbeat"></i>
    <h3>Quality Care</h3>
    <p>We are committed to providing the highest quality care to our clients.</p>
  </div>
  <div class="feature">
    <i class="fas fa-child"></i>
    <h3>Child-Friendly Environment</h3>
    <p>We provide a welcoming, comfortable and safe space for all children.</p>
  </div>
</div>

<?php if(auth()->guard()->guest()): ?>
  <div style="text-align: center; margin-top: 30px;">
    <a href="<?php echo e(route('login')); ?>" class="btn">Login</a>
    <a href="<?php echo e(route('register')); ?>" class="btn">Register</a>
  </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/home.blade.php ENDPATH**/ ?>