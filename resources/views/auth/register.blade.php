@extends('layout')
@section('title', 'Register')
@section('content')
<x-guest-layout>
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="d-flex justify-content-start align-items-start" style="position: absolute; top: 40px; left: 40px;">
        <a class="btn btn-close btn-md" href="{{ route('home') }}"></a>
      </div>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="card-body p-md-5 mx-md-4">

                        <div class="d-flex justify-content-center">
                        <img src="{{ asset('images/logo.jpg') }}"
                        style="width: 180px;" alt="logo">
                        </div>

                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            <x-validation-errors class="mb-4" />

                            <p class="mb-4">Register your Staff Account</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" value="{{old('firstname')}}" required autofocus autocomplete="firstname"/>
                                        <label for="firstname">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name" value="{{old('middlename')}}" autocomplete="middlename"/>
                                        <label for="middlename">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" value="{{old('lastname')}}" required autocomplete="lastname"/>
                                        <label for="lastname">Last Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" name="gender" id="gender">
                                            <option disabled {{ old('gender') === null ? 'selected' : ''}}></option>
                                            @foreach($genders as $gender)
                                            <option value="{{$gender->id}}"  {{ old('gender') === $gender->id ? 'selected' : '' }}>{{$gender->gender}}</option>
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
                                            <option value="{{$role->id}}" {{old('role') === $role->id ? 'selected' : ''}}>{{$role->role}}</option>
                                            @endforeach
                                        </select>
                                        <label for="role">Role</label>
                                    </div>
                                </div>

                                <div class="col-md-6" id="specs" style="display: none">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" name="specialization" id="specialization">
                                            <option disabled {{old('specialization') === null ? 'selected' : ''}}></option>
                                            @foreach($specializations as $item)
                                            <option value="{{$item->id}}" {{old('specialization') === $item->id ? 'selected' : ''}}>{{$item->specialization}}</option>
                                            @endforeach
                                        </select>
                                        <label for="specialization">Specialization</label>
                                    </div>
                                </div>

                                <script>
                                    $('#role').change( function() {
                                        if ($(this).val() === "2" || $(this).val() === "5") {
                                            $('#specs').css('display', 'block');  
                                        } else {
                                            $('#specs').css('display', 'none'); 
                                        }
                                    });

                                </script>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" required autocomplete="username" />
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" id="telephone" name="telephone" class="form-control" placeholder="Phone Number" value="{{old('telephone')}}" required />
                                        <label for="telephone">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            
                            @livewire('password-generator')

                            <script>
        
                                document.addEventListener('DOMContentLoaded',()=>{
                        
                                    const togglePassword= document.querySelector('#togglePassword');
                                    const password=document.querySelector('#password');
                                    togglePassword.addEventListener('click',(e)=>{
                                        const type = password.getAttribute('type')==='password' ? 'text' : 'password';
                                        password.setAttribute('type',type);
                                        e.target.classList.toggle('bi-eye');
                                    });
                        
                                    const togglePassword2= document.querySelector('#togglePassword2');
                                    const c_password=document.querySelector('#password_confirmation');
                                    togglePassword2.addEventListener('click',(e)=>{
                                        const type2 = c_password.getAttribute('type')==='password' ? 'text' : 'password';
                                        c_password.setAttribute('type',type2);
                                        e.target.classList.toggle('bi-eye');
                                    });
                                });
                        
                            </script>

                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

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
</x-guest-layout>
@endsection