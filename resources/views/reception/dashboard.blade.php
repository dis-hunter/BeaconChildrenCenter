@extends('reception.layout')
@section('title','Dashboard | Reception')
@extends('reception.header')
@section('content')
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
                <div class="row">
                    {{-- Appointments --}}
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h6>Appointment Overview</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h6>Payment Overview</h6>
                    </div>
                </div>
            </div>
            


        </div>
        <div class="row mt-4">
            
            <div class="col-md-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <h5>Available Doctors</h5>
                    <ul class="list-group">
                      <li class="list-group-item">Dr. Susana Thompson - Physician</li>
                      <li class="list-group-item">Dr. Susana Thompson - Physician</li>
                      <!-- Repeat doctor entries as needed -->
                    </ul>
                  </div>
                </div>
              </div>
            <div class="col-md-6 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5>Today's Appointments</h5>
                  <ul class="list-group">
                    <li class="list-group-item">8:00 AM - Deepak Shrestha (On-going)</li>
                    <li class="list-group-item">9:00 AM - Deepak Shrestha (Pending)</li>
                    <!-- Repeat appointments -->
                  </ul>
                </div>
              </div>
            </div>
            <!-- Appointment Behaviour -->
            <div class="col-md-6 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5>Appointment Behaviour</h5>
                  <canvas id="appointmentChart"></canvas>
                </div>
              </div>
            </div>
          </div>

                </div>
           

            <!-- Sidebar -->
            <div class="col-md-5 col-lg-3 p-3">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                          <div class="card-body">
                            <p>August 2023</p>
                            <div id="calendar"></div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
    </div>
        </div>   
    
@endsection