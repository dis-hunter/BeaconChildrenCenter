@extends('reception.layout')
@section('title','Child | Reception')
@extends('reception.header')
@section('content')

<div class="container mt-5">
    <div x-data="{showForm:false}">
    
        <button @click="showForm = !showForm" class="btn btn-primary mb-3">
        New Parent & Child
    </button>
    <form action="/patients" method="post" class="bg-light p-4 rounded shadow-sm"  x-show="showForm" 
    x-transition >

        @csrf
        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                
                                
                                <div>
                                    
                                    <p>{{$error}}</p>
                                    
                                </div>
                                
                            </div>
                            @endforeach
                            @endif
                            <h3 class="text-center mb-4">Parent/Guardian</h3>
        <!-- Fullname Fields -->
        <div class="row g-3">
            <div class="col-md-4">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" id="middlename" name="middlename" value="{{ old('middlename') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="lastname" class="form-label">Surname</label>
                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" class="form-control" required>
            </div>
        </div>

        <!-- Date of Birth and Gender -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="{{ old('dob') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="gender_id" class="form-label">Gender</label>
                <select id="gender_id" name="gender_id" class="form-select" required>
                    <option disabled {{old('gender_id') === null ? 'selected' : ''}}>Select...</option>
                    @foreach ($genders as $item)
                    <option value="{{$item->gender}}" {{old('gender_id') === $item->gender ? 'selected' : ''}}>{{$item->gender}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="national_id" class="form-label">National ID</label>
                <input type="text" id="national_id" name="national_id" value="{{ old('national_id') }}" class="form-control" required>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="employer" class="form-label">Employer</label>
                <input type="text" id="employer" name="employer" value="{{ old('employer') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="insurance" class="form-label">Insurance</label>
                <input type="text" id="insurance" name="insurance" value="{{ old('insurance') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="referer" class="form-label">Referer</label>
                <input type="text" id="referer" name="referer" value="{{ old('referer') }}" class="form-control">
            </div>
        </div>

        <!-- Relationship -->
        <div class="row g-3 mt-3">
            <div class="col-md-12">
                <label for="relationship_id" class="form-label">Relationship</label>
                <select id="relationship_id" name="relationship_id" class="form-select">
                    <option disabled {{old('relationship_id') === null ? 'selected' : ''}}>Select...</option>
                    @foreach ($relationships as $item)
                        <option value="{{$item->relationship}}" {{old('relationship_id') === $item->relationship ? 'selected' : ''}}>{{$item->relationship}}</option>
                        
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="mt-4">
        <h3 class="text-center mb-4">Child</h3>
        <!-- First Name, Middle Name, and Surname -->
        <div class="row g-3">
            <div class="col-md-4">
                <label for="firstname2" class="form-label">First Name</label>
                <input type="text" id="firstname2" name="firstname2" value="{{ old('firstname2') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="middlename2" class="form-label">Middle Name</label>
                <input type="text" id="middlename2" name="middlename2" value="{{ old('middlename2') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="lastname2" class="form-label">Surname</label>
                <input type="text" id="lastname2" name="lastname2" value="{{ old('lastname2') }}" class="form-control">
            </div>
        </div>

        <!-- Date of Birth and Gender -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="dob2" class="form-label">Date of Birth</label>
                <input type="date" id="dob2" name="dob2" value="{{ old('dob2') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="gender_id2" class="form-label">Gender</label>
                <select id="gender_id2" name="gender_id2" class="form-select">
                    <option disabled {{old('gender_id2') === null ? 'selected' : ''}}>Select...</option>
                    @foreach ($genders as $item)
                    <option value="{{$item->gender}}" {{old('gender_id2') === $item->gender ? 'selected' : ''}}>{{$item->gender}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Birth Certificate and Registration Number -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="birth_cert" class="form-label">Birth Certificate</label>
                <input type="text" id="birth_cert" name="birth_cert" value="{{ old('birth_cert') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="registration_number" class="form-label">Registration Number</label>
                <input type="text" id="registration_number" name="registration_number" value="{{ old('registration_number') }}" class="form-control">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </div>
        </div>
                             @if(session()->has('error'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <div>
                                    
                                    {{session('error')}}
                                    
                                </div>
                            </div>
                            @endif
                            @if(session()->has('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <div>
                                    
                                    {{session('success')}}
                                    
                                </div>
                            </div>
                            @endif
    </form>
</div>

</div>


@endsection