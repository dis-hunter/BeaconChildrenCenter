<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Doctor</h2>

        <form action="/doctors" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            
            <div>
                <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Staff ID
                </label>
                <input 
                    type="text" 
                    id="staff_id" 
                    name="staff_id" 
                    placeholder="Enter staff ID" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                >
            </div>

            <div>
                <label for="specialization" class="block text-sm font-medium text-gray-700 mb-1">
                    Specialization
                </label>
                <input 
                    type="text" 
                    id="specialization" 
                    name="specialization" 
                    placeholder="Enter specialization" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
            >
                Add Doctor
            </button>
        </form>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if($errors->any()): ?>
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/doctor_form.blade.php ENDPATH**/ ?>