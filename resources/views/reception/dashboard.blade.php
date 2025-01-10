@extends('reception.layout')
@section('title','Dashboard | Reception')
@extends('reception.header')
@section('content')

<div class="d-flex flex-column align-items-center mt-1">
  <div class="w-100 text-left">
    <h6>Welcome</h6>
  </div>
  <div class="text-center">
    <img src="{{ asset('images/logo-transparent.png') }}" 
      style="width: 100px; transform: scale(1.8);" alt="logo">
  </div>
</div>


    

    <style>
        .row-striped:nth-of-type(odd){
  background-color: #efefef;
  border-left: 4px #000000 solid;
  
}
img {
  display: block;
  margin: 0 auto;
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
                  <div class="row">
                    <div class="d-flex justify-content-between">
                    <h5>Today's Appointments</h5>
                    <a href="#">View all</a>
                  </div>
                  </div>
                  <div style="height: 400px; overflow-y: auto; overflow-x:hidden;">
                  @if($dashboard)
                  @foreach ($dashboard->appointments as $item)
                  <div class="row row-striped"> 
                    <div class="col-10"> 
                        <h5 class="text-uppercase"><strong>{{$item->appointment_title ?? 'Not Specified'}}</strong></h5> 
                        <ul class="list-inline"> 
                            <li class="list-inline-item"><i class="bi bi-calendar" aria-hidden="true"></i> {{Carbon\Carbon::parse($item->appointment_date)->format('l');}}</li> 
                            <li class="list-inline-item"><i class="bi bi-clock" aria-hidden="true"></i> {{$item->start_time}} - {{$item->end_time}}</li> 
                            <li class="list-inline-item"><i class="bi bi-activity" aria-hidden="true"></i> {{ucwords($item->status)}}</li> 
                        </ul> 
                        <div class="row">
                          <div class="d-flex justify-content-between align-content-center">
                            <h6>Actions</h6>
                            <div>
                            <button class="btn btn-dark">Start</button>
                            <button class="btn btn-dark">Reschedule</button>
                            <button class="btn btn-dark">cancel</button>
                          </div>
                          </div>
                        </div>
                    </div> 
                </div>
                @endforeach
                @else
                <div>
                  <div class="alert alert-danger">Error fetching Appointments</div>
                </div>
                @endif
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
                <div class="row mt-4">
                  <div class="card">
                    <div class="card-body">
                      <h6>Available Doctors</h6>

                      <ul class="list-group">
                        @forelse ($dashboard->activeUsers as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              <div>
                                <span class="text-success">•</span>
                               {{ ($item->fullname->last_name ?? '').' '.($item->fullname->first_name ?? '') }}
                              </div>
                            </li>
                        @empty
                            <div>Error fetching Doctor Details</div>
                        @endforelse
                      </ul>
                    </div>
                  </div>
                </div>
            </div>
    </div>
        </div>   
    
@endsection