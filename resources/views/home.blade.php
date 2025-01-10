@extends('layout')
@section('title','Homepage')
@extends('header')
@section('content')

<style>
  body {
    margin-left: 200px; /* Keep this if you have a sidebar */
    font-family: 'Arial', sans-serif;
    background: #f4f4f4;
    color: #333;
  }

  .container {
    max-width: 960px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
  }

  h1 {
    text-align: center;
    color: #007bff; /* Blue color */
    margin-bottom: 30px;
    transition: transform 0.2s ease, text-shadow 0.2s ease; /* Add transitions */
  }



  .welcome-message {
    text-align: center;
    font-size: 1.2em;
    margin-bottom: 20px;
  }

  .btn {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff; /* Blue color */
    color: #fff;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .btn:hover {
    background: #0069d9; /* Darker blue on hover */
  }

  .features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive columns */
    gap: 20px;
    margin-top: 40px;
  }

  .feature {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease; /* Add transitions */
  }

  .feature:hover {
    transform: translateY(-5px); /* Move slightly up on hover */
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* Add a more pronounced shadow */
  }

  .feature i {
    font-size: 3em;
    color: #007bff; /* Blue color */
    margin-bottom: 10px;
  }

  .feature h3 {
    margin-bottom: 10px;
  }
  .subheading { /* Style for the subheading */
    text-align: center;
    font-size: 1.3em;
    color: #007bff;
    margin-top: -15px; /* Adjust spacing as needed */
    margin-bottom: 30px;
  }
</style>

<div class="container">
  <h1>Beacon Children Center</h1>
  <p class="subheading">Your Neurodevelopmental Clinic</p> 

  @auth
    <p class="welcome-message">Hello, {{ auth()->user()->fullname->first_name }}!</p> 
  @endauth

  <div class="features">
    <div class="feature">
      <i class="fas fa-user-md"></i>
      <h3>Experienced Doctors</h3>
      <p>Our clinic has a team of experienced and qualified doctors.</p>
    </div>
    <div class="feature">
      <i class="fas fa-calendar-check"></i>
      <h3>Easy Appointments</h3>
      <p>Schedule appointments online or by phone with ease.</p>
    </div>
    <div class="feature">
      <i class="fas fa-heartbeat"></i>
      <h3>Quality Care</h3>
      <p>We are dedicated to providing the highest quality care to our patients.</p>
    </div>
    <div class="feature"> 
      <i class="fas fa-child"></i> 
      <h3>Child-Friendly Environment</h3>
      <p>We provide a comfortable and welcoming space for children.</p>
    </div>
  </div>

  @guest 
    <div style="text-align: center; margin-top: 30px;">
      <a href="{{ route('login') }}" class="btn">Login</a>
      <a href="{{ route('register') }}" class="btn">Register</a>
    </div>
  @endguest
</div>

@endsection