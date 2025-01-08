@extends('reception.layout')
@section('title','Patient Details')
@extends('reception.header')
@section('content')

<style>
    .card-header {
        background-color: #f8f9fa;
    }
    .icon {
        font-size: 1.2rem;
    }
    .section-title {
        font-weight: bold;
        font-size: 1.2rem;
    }
    .pill {
        display: inline-block;
        padding: 0.3rem 0.6rem;
        margin-right: 0.3rem;
        background-color: #f8d7da;
        border-radius: 20px;
        color: #721c24;
    }
    .review-btn {
        margin-top: 1rem;
    }
</style>
</head>
<body>

    
<div class="container py-4">
    <!-- Header Section -->

    @if ($child)
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">{{$child->fullname->first_name ?? ''.' '.$child->fullname->middle_name ?? ''. ' '. $child->fullname->last_name ?? ''}}</h5>
                    <p class="text-muted">{{$gender->gender}}, Age {{$child->age}}</p>
                    <p><strong>{{$child->registration_number}}</strong></p>
                    <p class="text-muted">nithya.kayakumar@gmail.com</p>
                    <p><strong>Last Visited:</strong> {{$last_visit->visit_date}}, {{$last_visit->visitType->first()->visit_type}}</p>
                    <div>
                        <span class="pill">Peanut Allergy</span>
                        <span class="pill">Lactose Intolerant</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>Latest Vitals</h5>
                        {{-- <a href="#" class="btn btn-outline-primary btn-sm">Edit</a> --}}
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <p class="text-muted">Head Circumference</p>
                            <p><strong>{{$triage->data->head_circumference.' m' ?? 'Missing'}}</strong></p>
                            
                        </div>
                        <div class="col-sm-4">
                            <p class="text-muted">Pulse Rate</p>
                            <p><strong>{{$triage->data->pulse_rate.' bpm' ?? 'Missing'}}</strong></p>
                            
                        </div>
                        <div class="col-sm-4">
                            <p class="text-muted">Temperature</p>
                            <p><strong>{{$triage->data->temperature.'°C' ?? 'Missing'}}</strong></p>
                            
                            
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <p class="text-muted">Blood Pressure</p>
                            <p><strong>{{$triage->data->blood_pressure.' mm Hg' ?? 'Missing'}}</strong></p>
                            
                            
                        </div>
                        <div class="col-sm-4">
                            <p class="text-muted">Respiratory Rate</p>
                            <p><strong>{{$triage->data->respiratory_rate.' bpm' ?? 'Missing'}}</strong></p>
                           
                        </div>
                        <div class="col-sm-4">
                            <p class="text-muted">Oxygen Saturation</p>
                            <p><strong>{{$triage->data->oxygen_saturation.'%' ?? 'Missing'}}</strong></p>
        
                        </div>
                        
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <p class="text-muted">MUAC</p>
                            <p><strong>{{$triage->data->muac.' cm' ?? 'Missing'}}</strong></p>
                           
                        </div>
                        <div class="col-sm-4">
                            <p class="text-muted">Height</p>
                            <p><strong>{{$triage->data->height.' cm' ?? 'Missing'}}</strong></p>
                            
                        </div>
                        <div class="col-sm-4">
                            <p class="text-muted">Weight</p>
                            <p><strong>{{$triage->data->weight.' Kg' ?? 'Missing'}}</strong></p>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections -->
    <div class="mt-4">
        <div class="accordion" id="dashboardAccordion">
            <!-- Past Records -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPastRecords">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePastRecords" aria-expanded="true" aria-controls="collapsePastRecords">
                        Past Records (Careplan)
                    </button>
                </h2>
                <div id="collapsePastRecords" class="accordion-collapse collapse show" aria-labelledby="headingPastRecords" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <pre>{{ json_decode($careplan_data), JSON_PRETTY_PRINT }}</pre>
                    </div>
                </div>
            </div>

            <!-- Reasons for Consultation -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingReasons">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReasons" aria-expanded="false" aria-controls="collapseReasons">
                        Reasons for Consultation
                    </button>
                </h2>
                <div id="collapseReasons" class="accordion-collapse collapse" aria-labelledby="headingReasons" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <!-- Dynamic Form Here -->
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDiagnosis">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiagnosis" aria-expanded="false" aria-controls="collapseDiagnosis">
                        Diagnosis
                    </button>
                </h2>
                <div id="collapseDiagnosis" class="accordion-collapse collapse" aria-labelledby="headingDiagnosis" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <!-- Dynamic Form Here -->
                    </div>
                </div>
            </div>

            <!-- Medication -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingMedication">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMedication" aria-expanded="false" aria-controls="collapseMedication">
                        Medication
                    </button>
                </h2>
                <div id="collapseMedication" class="accordion-collapse collapse" aria-labelledby="headingMedication" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <!-- Dynamic Form Here -->
                    </div>
                </div>
            </div>

            <!-- Follow-Up -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFollowUp">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFollowUp" aria-expanded="false" aria-controls="collapseFollowUp">
                        Follow Up
                    </button>
                </h2>
                <div id="collapseFollowUp" class="accordion-collapse collapse" aria-labelledby="headingFollowUp" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <!-- Content Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Button -->
    <div class="text-center review-btn">
        <button class="btn btn-primary">Review</button>
    </div>

    @else
        <p>Search for patient in the Search Component above</p>
    @endif
</div>

@endsection