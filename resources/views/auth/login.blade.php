@extends('layout')
@section('title','Login')
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
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="d-flex justify-content-center">
                  <img src="{{ asset('images/logo.jpg') }}"
                    style="width: 100px;" alt="logo">
                 
                </div>

                <form action="{{ route('login') }}" method="post">
                  @csrf

                  <x-validation-errors class="mb-4" />

                  @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                  @endif

                  <p class="mb-2">Please login to your account</p>
                

                  <div data-mdb-input-init class="form-floating form-outline mb-4">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Email" required autofocus autocomplete="username"/>
                    <label class="form-label" for="email_login">Email</label>
                  </div>

                  <div data-mdb-input-init class="form-floating form-outline mb-4">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="current-password" />
                    <i class="bi bi-eye-slash" id="toggleLoginPassword" style="transform: scale(1.2);"></i>
                    <label class="form-label" for="password">Password</label>
                    <script>
                      document.addEventListener('DOMContentLoaded',()=>{
                        const togglePassword= document.querySelector('#toggleLoginPassword');
                        const password=document.querySelector('#password');
                        togglePassword.addEventListener('click',(e)=>{
                            const type = password.getAttribute('type')==='password' ? 'text' : 'password';
                            password.setAttribute('type',type);
                            e.target.classList.toggle('bi-eye');
                        });
                    });
                    </script>
                  </div>

                  <div class="block mt-4 mb-3">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>


                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" style="width:100%">Log
                      in</button>
                      <div class="flex items-center justify-end mt-1">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                  </div>
                  

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a href="{{route('register')}}">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button></a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">We are more than just a hospital</h4>
                <p class="small mb-0">Your health. Our priority. Beacon Children Center. Where healing begins.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</x-guest-layout>
@endsection