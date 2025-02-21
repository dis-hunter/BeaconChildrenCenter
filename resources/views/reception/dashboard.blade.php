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
    .row-striped:nth-of-type(odd) {
        background-color: #efefef;
        border-left: 4px #000000 solid;

    }

    img {
        display: block;
        margin: 0 auto;
    }

    .row-striped:nth-of-type(even) {
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
            this.appointments = await appointmentsRes.json();
            this.activeUsers = await usersRes.json();
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
                                        <template x-for="appointment in appointments.appointments" :key="appointment.id">
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

                                    <template x-if="!loading && !appointments.length">
                                        <div class="alert alert-info">
                                            No appointments for today.
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Sidebar -->
            <div class="col-md-12 col-xl-3 p-3">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="calendar">
                            <div class="header">
                                <div class="month"></div>
                                <div class="btns">
                                    <!-- today -->
                                    <div class="btn today">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <!-- previous month -->
                                    <div class="btn prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                    <!-- next month -->
                                    <div class="btn next">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="weekdays">
                                <div class="day">S</div>
                                <div class="day">M</div>
                                <div class="day">T</div>
                                <div class="day">W</div>
                                <div class="day">T</div>
                                <div class="day">F</div>
                                <div class="day">S</div>
                            </div>
                            <div class="days">
                                <!-- render days with js -->
                            </div>
                        </div>
                        <script src="{{asset('js/dashboard_calendar.js')}}"></script>
                        <style>
                            :root {
                                --primary-color: #f90a39;
                                --text-color: #FFFFFF;
                                --bg-color: #000000;
                            }

                            .calendar {
                                width: 100%;
                                max-width: 600px;
                                background: var(--bg-color);
                                padding: 30px 20px;
                                border-radius: 10px;
                            }

                            .calendar .header {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin-bottom: 20px;
                                padding-bottom: 20px;
                                border-bottom: 2px solid #ccc;
                            }

                            .calendar .header .month {
                                display: flex;
                                align-items: center;
                                font-size: 25px;
                                font-weight: 600;
                                color: var(--text-color);
                            }

                            .calendar .header .btns {
                                display: flex;
                                gap: 10px;

                            }

                            .calendar .header .btns .btn {
                                width: 20px;
                                height: 20px;
                                background: var(--primary-color);
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 5px;
                                color: #fff;
                                font-size: 16px;
                                cursor: pointer;
                                transition: all 0.3s;
                            }

                            .calendar .header .btns .btn:hover {
                                background: #db0933;
                                transform: scale(1.05);
                            }

                            .calendar .weekdays {
                                display: flex;
                                gap: 10px;
                                color: var(--text-color);
                                margin-bottom: 10px;
                            }

                            .calendar .weekdays .day {
                                width: calc(100% / 7 - 10px);
                                text-align: center;
                                font-size: 16px;
                                font-weight: 600;
                            }

                            .calendar .days {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 10px;
                            }

                            .calendar .days .day {
                                width: calc(100% / 7 - 10px);
                                height: 50px;
                                background: #000000;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 5px;
                                font-size: 16px;
                                font-weight: 400;
                                color: var(--text-color);
                                transition: all 0.3s;
                                user-select: none;
                            }

                            .calendar .days .day:not(.next):not(.prev):hover {
                                color: #fff;
                                background: var(--primary-color);
                                transform: scale(1.05);
                            }

                            .calendar .days .day.next,
                            .calendar .days .day.prev {
                                color: #ccc;
                            }

                            .calendar .days .day.today {
                                color: #fff;
                                background: var(--primary-color);
                                font-size: 16px;
                                font-weight: 700;
                            }
                        </style>

                    </div>

                </div>
                <div class="row mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h6>Available Doctors</h6>

                            <template x-if="loading">
                                <div id="loading">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!loading && activeUsers">
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
                            </template>

                            <template x-if="!loading && !activeUsers.length">
                                <div class="alert alert-info">
                                    No Active Doctors Online!
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
