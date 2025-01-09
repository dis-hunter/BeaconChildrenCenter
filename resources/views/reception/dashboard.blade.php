@extends('reception.layout')
@section('title','Dashboard | Reception')
@extends('reception.header')
@section('content')

<div class="d-flex justify-content-center mt-1">
  <img src="{{ asset('images/logo-transparent.png') }}"
    style="width: 100px; transform: scale(1.8);" alt="logo">
 
</div>
    <div><h6>Welcome</h6></div>

    <style>
        .row-striped:nth-of-type(odd){
  background-color: #efefef;
  border-left: 4px #000000 solid;
  
}

.row-striped:nth-of-type(even){
  background-color: #ffffff;
  border-left: 4px #efefef solid;
}

.row-striped {
    padding: 15px 0;
}
    </style>

	<div class="container-fluid">
        
        <div class="row">
            <div class="col-md-8 col-lg-9 p-3">
                <div class="row gy-3">
                    {{-- Appointments --}}
                    <div class="col-md-6 col-lg-6">
                      <div class="card shadow-sm border-0">
                          <div class="card-body">
                              <h6 class="text-uppercase text-muted mb-4">Appointment Overview</h6>
                              <div class="d-flex justify-content-between align-items-center kontainer">

                                @if ($dashboard)
                                
                                  <div class="text-center">
                                    <span class="mb-1 text-primary fs-1">40</span>
                                      <p class="font-weight-bold">Total</p>
                                  </div>
                                  <div class="text-center">
                                    <span class="mb-1 text-success fs-1">40</span>
                                      <p class="font-weight-bold">On-going</p>
                                      
                                  </div>
                                  <div class="text-center">
                                    <span class="mb-1 text-warning fs-1">40</span>
                                      <p class="font-weight-bold">Pending</p>
                                      
                                  </div>
                                  <div class="text-center">
                                    <span class="mb-1 text-danger fs-1">40</span>
                                      <p class="font-weight-bold">Rejected</p>
                                      
                                  </div>
                                      
                                @else
                                <div
                                class="alert alert-danger w-100"
                                role="alert"
                              >
                                <strong>Error</strong> Fetching Details
                              </div>
                                @endif
                              </div>
                          </div>
                      </div>
                  </div>
                  

                  <div class="col-md-6 col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted mb-4">Payment Overview</h6>
                            <div class="d-flex justify-content-between align-items-center kontainer px-4">
                              @if ($dashboard)
                      
                                <div class="text-center">
                                  <span class="mb-1 text-success fs-1">40</span>
                                    <p class="font-weight-bold">Accepted</p>
                                    
                                </div>
                                <div class="text-center">
                                  <span class="mb-1 text-warning fs-1">40</span>
                                    <p class="font-weight-bold">Pending</p>
                                    
                                </div>
                                <div class="text-center">
                                  <span class="mb-1 text-danger fs-1">40</span>
                                    <p class="font-weight-bold">Rejected</p>
                                  
                                </div>
                                @else

                                <div
                                  class="alert alert-danger w-100"
                                  role="alert"
                                >
                                  <strong>Error</strong> Fetching Details
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            


        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5>Today's Appointments</h5>
                  <div class="row row-striped">
                    {{-- <div class="col-2 text-right">
                      <h1 class="display-4"><span class="badge badge-secondary">23</span></h1>
                      <h2>OCT</h2>
                    </div> --}}
                    <div class="col-10">
                      <h3 class="text-uppercase"><strong>Ice Cream Social</strong></h3>
                      <ul class="list-inline">
                          <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> Monday</li>
                        <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> 12:30 PM - 2:00 PM</li>
                        <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> Cafe</li>
                      </ul>
                      <p>Lorem ipsum dolsit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                  </div>
                  <div class="row row-striped">
                    <div class="col-2 text-right">
                      <h1 class="display-4"><span class="badge badge-secondary">27</span></h1>
                      <h2>OCT</h2>
                    </div>
                    <div class="col-10">
                      <h3 class="text-uppercase"><strong>Operations Meeting</strong></h3>
                      <ul class="list-inline">
                          <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> Friday</li>
                        <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> 2:30 PM - 4:00 PM</li>
                        <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> Room 4019</li>
                      </ul>
                      <p>Lorem ipsum dolsit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <style>
            .row-striped:nth-of-type(odd){
              background-color: #efefef;
              border-left: 4px #000000 solid;
            }

            .row-striped:nth-of-type(even){
              background-color: #ffffff;
              border-left: 4px #efefef solid;
            }

            .row-striped {
                padding: 15px 0;
            }
          </style>

                </div>
           

            <!-- Sidebar -->
            <div class="col-md-5 col-lg-3 p-3">
                <div class="row">
                        <div class="d-flex justify-content-center">
                          
                            <div id="calendar" class="calendar ml-auto">
                              <p id="monthName"></p>
                              <strong id="dayName"></strong>
                              <p id="day"></p>
                              <strong id="year"></strong>
                            </div>
                            <script>
                              let lang=navigator.language;
                              let date = new Date();
                              let day = date.getDate();
                              let month= date.getMonth();
                              let dayName= date.toLocaleString(lang,{weekday:'long'});
                              let monthName= date.toLocaleString(lang,{month:'long'});
                              let year=date.getFullYear();

                              document.getElementById('monthName').innerHTML=monthName;
                              document.getElementById('dayName').innerHTML=dayName;
                              document.getElementById('day').innerHTML=day;
                              document.getElementById('year').innerHTML=year;
                            </script>
                            <style>
                              .calendar{
                                position: relative;
                                width: 200px;
                                background-color:#ffffff; 
                                border-radius: 8px;
                                text-align: center;
                                overflow: hidden;
                              }
                              .calendar #monthName{
                                position: relative;
                                padding: 5px 10px;
                                background: rgb(122, 20, 255);
                                color: #ffffff;
                                font-size: 30px;
                                font-weight: 700;
                              }

                              .calendar #dayName{
                                margin-top: 20px;
                                font-size: 20px;
                                font-weight: 300;
                                color: #000000;

                              }
                              .calendar #day{
                                margin-top: 0px;
                                line-height: 1em;
                                font-size: 60px;
                                font-weight: 700;
                                color: #333333;
                                
                              }
                              .calendar #year{
                                margin-bottom: 20px;
                                font-size: 20px;
                                font-weight: 300;
                                color: #000000;
                                
                              }
                            </style>
                          
                        </div>
                      
                </div>
            </div>
    </div>
        </div>   
    
@endsection