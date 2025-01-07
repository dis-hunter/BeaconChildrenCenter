@extends('layout')
@section('title', 'Register')
@section('content')
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="d-flex justify-content-start align-items-start" style="position: absolute; top: 40px; left: 40px;">
        <a class="btn btn-close btn-md" href="{{ route('register') }}"></a>
      </div>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="card-body p-md-5 mx-md-4">

                        <div class="text-center">
                            <img src="" style="width: 185px;" alt="logo">AddImage
                            <h4 class="mt-1 mb-5 pb-1">Beacon Children Center</h4>
                        </div>

                        <form action="/register" method="post">
                            @csrf
                            <p class="mb-4">Register your Staff Account</p>
                            @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                
                                <div>
                                    
                                    <p>{{$error}}</p>
                                    
                                </div>
                                
                            </div>
                            @endforeach
                            @endif
                                
                           
                            @if(session()->has('error'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>
                                    
                                    {{session('error')}}
                                    
                                </div>
                            </div>
                            @endif
                            @if(session()->has('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <div>
                                    
                                    {{session('success')}}
                                    
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" value="{{old('firstname')}}" required />
                                        <label for="firstname">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name" value="{{old('middlename')}}" required />
                                        <label for="middlename">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" value="{{old('lastname')}}" required />
                                        <label for="lastname">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" name="gender" id="gender">
                                            <option disabled {{ old('gender') === null ? 'selected' : ''}}></option>
                                            @foreach($genders as $gender)
                                            <option value="{{$gender->gender}}"  {{ old('gender') === $gender->gender ? 'selected' : '' }}>{{$gender->gender}}</option>
                                            @endforeach
                                        </select>
                                        <label for="gender">Gender</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" name="role" id="role">
                                            <option disabled {{old('role') === null ? 'selected' : ''}}></option>
                                            @foreach($roles as $role)
                                            <option value="{{$role->role}}" {{old('role') === $role->role ? 'selected' : ''}}>{{$role->role}}</option>
                                            @endforeach
                                        </select>
                                        <label for="role">Role</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="email" id="email_register" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" required />
                                        <label for="email_register">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" value="{{old('phone')}}" required />
                                        <label for="phone">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="col-md-8">
                                            <div class="form-floating mb-4">
                                                <input type="password" id="password-input" name="password" class="form-control" placeholder="Password" wire:model="password" required />
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <button class="btn btn-dark w-100" style="padding:10px;" type="button" wire:click="generatePassword">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <link rel="stylesheet" href="{{asset('css/style.css')}}">
                                    <label for="password-meter">Password Strength</label>
                                    <div class="password-meter">
                                        <div class="meter-section rounded me-2"></div>
                                        <div class="meter-section rounded me-2"></div>
                                        <div class="meter-section rounded me-2"></div>
                                        <div class="meter-section rounded"></div>
                                    </div>
                                    <div id="passwordHelp" class="form-text text-muted mb-4">Use 8 or more characters with a mix of
                                        letters, numbers &
                                        symbols.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" wire:model="confirmpassword" required />
                                        <label for="confirmpassword">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div> --}}
                            @livewire('password-generator')

                            <div class="text-center pt-1 mb-5 pb-1">
                                <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" style="width:100%">Register</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-center pb-4">
                                <p class="mb-0 me-2">Already have an account?</p>
                                <a href="/login">
                                    <button type="button" class="btn btn-outline-danger">Log in</button>
                                </a>
                            </div>

                        </form>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection