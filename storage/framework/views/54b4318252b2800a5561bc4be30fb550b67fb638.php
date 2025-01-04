<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
</head>

<body>
    <div class="navbar">
        <form action="/logout" method="post">
            <?php echo csrf_field(); ?>
        <button class="btn btn-primary" type="submit">Logout</button>
        </form>
    </div>
    <h3>Step 1</h3>
    <p>Make sure table is in DB....Check in the migrations or use <a href="https://sqlectron.github.io/">sqlectron</a></p><br>
    <h3>Step 2: Create Model</h3>
    <p style="color: green;">php artisan make:model Example</p>
    <p>Model is in
        <b>app/Models/Example.php</b>
    </p>
    <p>// Specify the table name if it's not the pluralized form of the model name</p>
    <p style="color: green;">protected $table = 'example_table';</p>
    <br>
    <h3>Step 3: Create form in view</h3>
    <p>self-explanatory <b>resources/views/example.blade.php</b></p><br>
    <h2>Example POST Form</h2>
    <form action="<?php echo e(route('example.store')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <table>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo e(old('email')); ?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" value="<?php echo e(old('password')); ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Register" />
                </td>
            </tr>
        </table>
        <?php if(session()->has('success')): ?>
        <p style="color: blue;">
            <?php echo e(session()->get('success')); ?>

        </p>
        <?php endif; ?>
    </form>
    <br>

    <h2>Example GET from DB Table</h2>
    <table><thead><tr>
        <th>Id</th>
        <th>Email</th>
        <th>Password</th>
        <th>Created_at</th>
        <th>Updated_at</th>
</tr>
    </thead>
<tbody>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($item->id); ?></td>
    <td><?php echo e($item->email); ?></td>
    <td><?php echo e($item->password); ?></td>
    <td><?php echo e($item->created_at); ?></td>
    <td><?php echo e($item->updated_at); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
    <h3>Step 4: Create Controller</h3>
    <p style="color: green;">php artisan make:controller ExampleController</p>
    <p>Controller is in
        <b>app/Http/Controllers/ExampleController.php</b>
    </p>
    <p>Study the code</p><br>
    

    <h3>Step 5: Create Routes in <i>routes/web.php</i></h3>
    <p style="color: green;">Route::post('/example', [ExampleController::class, 'store'])->name('example.store')</p>
    <p style="color: green;">Route::get('/example', [ExampleController::class, 'fetch'])->name('example.fetch')</p>

</body>

</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/example.blade.php ENDPATH**/ ?>