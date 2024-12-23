<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
</head>

<body>
    <h3>Step 1</h3>
    <p>Make sure table is in DB....Check in the migrations or use <a href="https://sqlectron.github.io/">sqlectron</a></p><br>
    <h3>Step 2: Create Model</h3>
    <p style="color: green;">php artisan make:model Example</p>
    <p>Model is in
        <b>app/Models/Example.php</b>
    </p><br>
    <h3>Step 3: Create form in view</h3>
    <p>self-explanatory <b>resources/views/example.blade.php</b></p><br>
    <h2>Example POST Form</h2>
    <form action="{{ route('example.store') }}" method="post">
        @csrf
        <table>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="{{old('email')}}"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" value="{{old('password')}}"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Register" />
                </td>
            </tr>
        </table>
        @if(session()->has('success'))
        <p style="color: blue;">
            {{ session()->get('success') }}
        </p>
        @endif
    </form>
    <br>

    <h1>Example GET from DB Table</h1>
    <table><thead><tr>
        <th>Id</th>
        <th>Email</th>
        <th>Password</th>
        <th>Created_at</th>
        <th>Updated_at</th>
</tr>
    </thead>
<tbody>
@foreach ($data as $item)
<tr>
    <td>{{$item->id}}</td>
    <td>{{$item->email}}</td>
    <td>{{$item->password}}</td>
    <td>{{$item->created_at}}</td>
    <td>{{$item->updated_at}}</td>
</tr>
@endforeach
</tbody>
</table>
    <h3>Step 4: Create Controller</h3>
    <p style="color: green;">php artisan make:controller ExampleController</p>
    <p>Controller is in
        <b>app/Http/Controllers/ExampleController.php</b>
    </p><br>

    <h3>Step 5: Create Routes in <i>routes/web.php</i></h3>
    <p style="color: green;">Route::post('/example', [ExampleController::class, 'store'])->name('example.store')</p>
    <p style="color: green;">Route::get('/example', [ExampleController::class, 'fetch'])->name('example.fetch')</p>



</body>

</html>