<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Beacon Children Center')</title>
  <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
  <style>
    .gradient-custom-2 {
      background: #3457E6;

      background: -webkit-linear-gradient(to right, #208EDC, #3457E6, #0631BF, #6536DB);

      background: linear-gradient(to right, #208EDC, #3457E6, #0631BF, #6536DB);
    }

    .password-check div {
      display: flex;
      padding: 10px;
      align-items: center;
      font-weight: 500;
      color: red;
    }

    .password-check img {
      height: 25px;
      padding-right: 10px;
    }

    #togglePassword{
      float: right;
      margin-left: -25px;
      margin-top: -40px;
      right: 20px;
      position: relative;
      z-index: 2;

    }
    #togglePassword2{
      float: right;
      margin-left: -25px;
      margin-top: -40px;
      right: 20px;
      position: relative;
      z-index: 2;
    }

    #toggleLoginPassword{
      float: right;
      margin-left: -25px;
      margin-top: -40px;
      right: 20px;
      position: relative;
      z-index: 2;
    }
    @media (min-width: 768px) {
      .gradient-form {
        height: 100vh !important;
      }
      .responsive-navbar{
        position: static;
      }
      #mainNav.show ~ #Account{
        margin-top: 200px;
      }
    }
    @media (max-width: 768px) {
    .btn-close {
        display: none;
        transform: scale(0.9); /* Scales down the button size */
    }
}

    @media (min-width: 769px) {
      .gradient-custom-2 {
        border-top-right-radius: .3rem;
        border-bottom-right-radius: .3rem;
      }
    }
  </style>
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" viewBox="0 0 16 16">
      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
  </svg>
  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="{{asset('js/script.js')}}"></script>
  <script>
    Livewire.on('modalSaved', (data) => {
        $('#hidden_specialization').val(data.specialization);
        console.log('Selected Specialization:', data.specialization);
    });
</script>
    
</body>

</html>