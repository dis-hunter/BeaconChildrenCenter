<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/childreg.css') }}">
</head>
<body>
    


<!-- Search Form -->
 <div>
<form action="{{ route('parents.search') }}" method="post">
    @csrf
    <table>
        <tr>
            <td>Search by Telephone</td>
            <td><input type="text" name="telephone" placeholder="Enter Telephone" value="{{ old('telephone') }}"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
    </table>
</form>
</div>

<!-- Error Message -->
@if(session()->has('error'))
<p style="color: red;">
    {{ session()->get('error') }}
</p>
@endif

@if(isset($parent))
    <h3>Parent Record</h3>
    <table border="1">
        <tr>
            <td>Full Name</td>
            <td>{{ json_decode($parent->fullname)->firstname }} {{ json_decode($parent->fullname)->middlename }} {{ json_decode($parent->fullname)->surname }}</td>
        </tr>
        <tr>
            <td>Telephone</td>
            <td>{{ $parent->telephone }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $parent->email }}</td>
        </tr>
        <tr>
            <td>Action</td>
            <td>
                <form action="{{ route('children.create') }}" method="get">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                    <button type="submit">Use This Parent</button>
                </form>
            </td>
        </tr>
    </table>
@endif
<div class="container mt-5" style="border: 2px solid; border-radius: 10px; padding: 20px;">
    <!-- Flexbox Wrapper -->
    <div style="display: flex; align-items: flex-start; gap: 20px;">
        <!-- Image Section -->
        <div style="flex: 1; text-align: center;">
            <img src="/images/register_child.webp" alt="Register Child" style="margin-top:115px;width: 100%; height: 100% !important; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        </div>

        <!-- Form Section -->
        <div style="flex: 2;">
            <form action="{{ route('children.store') }}" method="post">
                @csrf

                <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">

                <!-- Form Header -->
                <div class="mb-4">
                    <h3>Register a Child</h3>
                </div> <br>

                <!-- First Name -->
                <div class="mb-3 row">
                    <label for="firstname" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Enter first name">
                    </div>
                </div> <br>

                <!-- Middle Name -->
                <div class="mb-3 row">
                    <label for="middlename" class="col-sm-3 col-form-label">Middle Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="middlename" name="middlename" value="{{ old('middlename') }}" placeholder="Enter middle name">
                    </div>
                </div> <br>

                <!-- Surname -->
                <div class="mb-3 row">
                    <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" placeholder="Enter surname">
                    </div>
                </div> <br>

                <!-- Date of Birth -->
                <div class="mb-3 row">
                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                    </div>
                </div> <br>

                <!-- Gender -->
                <div class="mb-3 row">
                    <label for="gender_id" class="col-sm-3 col-form-label">Gender</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="gender_id" name="gender_id">
                            <option value="1" {{ old('gender_id') == '1' ? 'selected' : '' }}>Male</option>
                            <option value="2" {{ old('gender_id') == '2' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div> <br>

                <!-- Birth Certificate -->
                <div class="mb-3 row">
                    <label for="birth_cert" class="col-sm-3 col-form-label">Birth Certificate</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="birth_cert" name="birth_cert" value="{{ old('birth_cert') }}" placeholder="Enter birth certificate number">
                    </div>
                </div> <br>

                <!-- Registration Number -->
                <div class="mb-3 row">
                    <label for="registration_number" class="col-sm-3 col-form-label">Registration Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="registration_number" name="registration_number" value="{{ old('registration_number') }}" placeholder="Enter registration number">
                    </div>
                </div> <br>

                <!-- Submit Button -->
                <div class="mb-3 row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div> <br>

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="alert alert-success mt-3">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>



</body>
</html>
