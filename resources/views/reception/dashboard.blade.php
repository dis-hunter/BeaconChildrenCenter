@extends('reception.layout')
@section('title','Dashboard | Reception')
@extends('reception.header')
@section('content')

    <div class="d-flex flex-column align-items-center mt-1 mb-2">
        <div class="w-100 text-left">
            <h6>Welcome</h6>
        </div>
        <div class="text-center">
            <img src="{{ asset('images/logo-transparent.png') }}"
                 loading="lazy"
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

    <div x-data="{
    stats: null,
    appointments: null,
    activeUsers: null,
    loading: true,
    async init() {
        try {
            // Load all data in parallel
            const [statsRes, appointmentsRes, usersRes] = await Promise.all([
                fetch('/dashboard/stats'),
                fetch('/dashboard/appointments'),
                fetch('/dashboard/active-users')
            ]);

            this.stats = await statsRes.json();
            console.log(this.stats);
            this.appointments = await appointmentsRes.json();
            console.log(this.appointments);
            this.activeUsers = await usersRes.json();
            console.log(this.activeUsers);
        } catch (error) {
            console.error('Failed to load dashboard data:', error);
        } finally {
            this.loading = false;
        }
    }
}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-xl-9 p-3">
                    <div class="row gy-3">
                        {{--Appointment Stats--}}
                        <div class="col-md-12 col-lg-7">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-4">Today's Appointment Overview</h6>

                                    <!-- Loading State -->
                                    <template x-if="loading">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Loaded State -->
                                    <template x-if="!loading && stats">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-center">
                                                <span class="mb-1 text-primary fs-1" x-text="stats.totalAppointments"></span>
                                                <p class="font-weight-bold">Total</p>
                                            </div>
                                            <div class="text-center">
                                                <span class="mb-1 text-success fs-1" x-text="stats.ongoingAppointments"></span>
                                                <p class="font-weight-bold">On-going</p>
                                            </div>
                                            <div class="text-center">
                                                <span class="mb-1 text-warning fs-1" x-text="stats.pendingAppointments"></span>
                                                <p class="font-weight-bold">Pending</p>
                                            </div>
                                            <div class="text-center">
                                                <span class="mb-1 text-danger fs-1" x-text="stats.rejectedAppointments"></span>
                                                <p class="font-weight-bold">Rejected</p>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Error State -->
                                    <template x-if="!loading && !stats">
                                        <div class="alert alert-danger w-100" role="alert">
                                            <strong>Error</strong> Fetching Stats
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{--Payments Stats--}}
                        <div class="col-md-12 col-lg-5">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-4">Today's Payments Overview</h6>

                                    <!-- Loading State -->
                                    <template x-if="loading">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                            <div class="text-center placeholder-glow">
                                                <span class="placeholder rounded-circle mb-2" style="width: 60px; height: 60px; display: inline-block;"></span>
                                                <br>
                                                <span class="placeholder rounded-pill col-6"></span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Loaded State -->
                                    <template x-if="!loading && stats">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-center">
                                                <span class="mb-1 text-primary fs-1" x-text="stats.totalAppointments"></span>
                                                <p class="font-weight-bold">Total</p>
                                            </div>
                                            <div class="text-center">
                                                <span class="mb-1 text-success fs-1" x-text="stats.ongoingAppointments"></span>
                                                <p class="font-weight-bold">On-going</p>
                                            </div>
                                            <div class="text-center">
                                                <span class="mb-1 text-warning fs-1" x-text="stats.pendingAppointments"></span>
                                                <p class="font-weight-bold">Pending</p>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Error State -->
                                    <template x-if="!loading && !stats">
                                        <div class="alert alert-danger w-100" role="alert">
                                            <strong>Error</strong> Fetching Stats
                                        </div>
                                    </template>
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
                                            <a href="{{route('reception.calendar')}}">View all</a>
                                        </div>
                                    </div>

                                    <div style="height: 400px; overflow-y: auto; overflow-x: hidden;">
                                        <template x-if="loading">
                                            <div id="loading">
                                                <div class="d-flex justify-content-center">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="!loading && appointments">
                                            <template x-for="appointment in appointments" :key="appointment.id">
                                                <div class="row row-striped">
                                                    <div class="col-10">
                                                        <h5 class="text-uppercase"><strong x-text="appointment.appointment_title ?? 'Not Specified'"></strong></h5>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><i class="bi bi-calendar" aria-hidden="true"></i> <span x-text="new Date(appointment.appointment_date).toLocaleDateString('en-US', {weekday : 'long'})"></span> </li>
                                                            <li class="list-inline-item"><i class="bi bi-clock" aria-hidden="true"></i> <span x-text="appointment.start_time"></span> - <span x-text="appointment.end_time"></span> </li>
                                                            <li class="list-inline-item"><i class="bi bi-activity" aria-hidden="true"></i> <span x-text="appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)"></span> </li>
                                                        </ul>
                                                        <div class="row">
                                                            <div class="d-flex justify-content-between align-content-center">
                                                                <h6>Actions</h6>
                                                                <div>
                                                                    <a href="{{ route('reception.calendar') }}" class="nav-link"><button class="btn btn-dark">Follow up</button></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Active Users Section -->
        <template x-if="!loading && activeUsers">
            <div class="card">
                <div class="card-body">
                    <h6>Available Doctors</h6>
                    <ul class="list-group">
                        <template x-for="user in activeUsers.activeUsers" :key="user.id">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-success">•</span>
                                    <span x-text="`${user.fullname.last_name} ${user.fullname.first_name}`"></span>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </template>
    </div>
@endsection
