@extends('reception.layout')
@section('title', 'Patient Details')
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
                                <div class="toReferral">
                                    <h5 class="card-title">
                                        {{ ($child->fullname->first_name ?? '') . ' ' . ($child->fullname->middle_name ?? '') . ' ' . ($child->fullname->last_name ?? '') }}
                                    </h5>
                                    <p class="text-muted">{{ $gender->gender }}, Age {{ $child->age }}</p>
                                    <p><strong>{{ $child->registration_number }}</strong></p>
                                    <p class="text-muted">Birth Certificate: {{ $child->birth_cert }}</p>
                                </div>
                                <p><strong>Last Visited:</strong> {{ $last_visit->visit_date ?? 'First Time' }},
                                    {{ $last_visit?->visitType?->first()?->visit_type ?? 'N/A' }}</p>
                                {{-- <div>
                        <span class="pill">Peanut Allergy</span>
                        <span class="pill">Lactose Intolerant</span>
                    </div> --}}
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
                                        <p><strong>{{ $triage?->data?->head_circumference ? $triage?->data?->head_circumference . ' m' : 'Missing' }}</strong>
                                        </p>

                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted">Pulse Rate</p>
                                        <p><strong>{{ $triage?->data?->pulse_rate ? $triage?->data?->pulse_rate . ' bpm' : 'Missing' }}</strong>
                                        </p>

                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted">Temperature</p>
                                        <p><strong>{{ $triage?->data?->temperature ? $triage?->data?->temperature . '°C' : 'Missing' }}</strong>
                                        </p>


                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-4">
                                        <p class="text-muted">Blood Pressure</p>
                                        <p><strong>{{ $triage?->data?->blood_pressure ? $triage?->data?->blood_pressure . ' mm Hg' : 'Missing' }}</strong>
                                        </p>


                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted">Respiratory Rate</p>
                                        <p><strong>{{ $triage?->data?->respiratory_rate ? $triage?->data?->respiratory_rate . ' bpm' : 'Missing' }}</strong>
                                        </p>

                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted">Oxygen Saturation</p>
                                        <p><strong>{{ $triage?->data?->oxygen_saturation ? $triage?->data?->oxygen_saturation . '%' : 'Missing' }}</strong>
                                        </p>

                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-4">
                                        <p class="text-muted">MUAC</p>
                                        <p><strong>{{ $triage?->data?->muac ? $triage?->data?->muac . ' cm' : 'Missing' }}</strong>
                                        </p>

                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted">Height</p>
                                        <p><strong>{{ $triage?->data?->height ? $triage?->data?->height . ' cm' : 'Missing' }}</strong>
                                        </p>

                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted">Weight</p>
                                        <p><strong>{{ $triage?->data?->weight ? $triage?->data?->weight . ' Kg' : 'Missing' }}</strong>
                                        </p>


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
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePastRecords" aria-expanded="true"
                                    aria-controls="collapsePastRecords">
                                    Doctor's Careplan
                                </button>
                            </h2>
                            <div id="collapsePastRecords" class="accordion-collapse collapse show"
                                aria-labelledby="headingPastRecords" data-bs-parent="#dashboardAccordion">
                                <div class="accordion-body">
                                    @if ($careplan)
                                        <p>Return Date:
                                            <strong>{{ $careplan?->data?->returnDate ?? 'Not Specified' }}</strong></p>
                                        <strong>Notes</strong>
                                        @if ($careplan->notes)
                                            <ul>
                                                @foreach ($careplan->notes as $key => $value)
                                                    <li><strong>{{ ucwords(str_replace('Notes', '', $key)) }}:</strong>
                                                        {{ $value }}</li><br>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No available Doctor's notes...</p>
                                        @endif
                                    @else
                                        <p>No careplan available...</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Reasons for Consultation -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingReasons">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseReasons" aria-expanded="false" aria-controls="collapseReasons">
                                    Therapist's Careplan
                                </button>
                            </h2>
                            <div id="collapseReasons" class="accordion-collapse collapse" aria-labelledby="headingReasons"
                                data-bs-parent="#dashboardAccordion">
                                <div class="accordion-body">
                                    @if ($therapist_careplan)
                                        <div class="row">

                                            <p>Return Dates:</p>

                                            <strong>
                                                @foreach ($therapist_careplan?->data?->Dates as $item)
                                                    {{ $item ?? 'Not Specified' }} <br>
                                                @endforeach
                                            </strong>
                                        </div>
                                    @else
                                        <p>No careplan available...</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Diagnosis -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDiagnosis">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseDiagnosis" aria-expanded="false"
                                    aria-controls="collapseDiagnosis">
                                    Prescription
                                </button>
                            </h2>
                            <div id="collapseDiagnosis" class="accordion-collapse collapse"
                                aria-labelledby="headingDiagnosis" data-bs-parent="#dashboardAccordion">
                                <div class="accordion-body">
                                    @if ($prescription)
                                        <div class="prescription">
                                            <p>Prescribed on: <strong>{{ $prescription->updated_at ?? 'N/A' }}</strong></p>
                                            {{ implode(' , ', $prescription->data->prescribed_drugs) ?? $prescription?->data?->prescribed_drugs }}
                                        </div>
                                        <div><button class="btn btn-outline-success mt-4" id="printButton">Print</button>
                                        </div>
                                        <script>
                                            const printButton = document.getElementById('printButton');
                                            printButton.addEventListener('click', () => {
                                                console.log("Print button clicked");
                                                const printWindow = window.open('', '_blank');
                                                const prescriptionContent = document.querySelector('.prescription').innerHTML;
                                                const patientDetails = document.querySelector('.toReferral').innerHTML;
                                                printWindow.document.write(`
                                <html>
                                <head>
                                    <title>Prescription</title>
                                    <style>
                                    body {
                                    font-family: sans-serif;
                                    margin: 0;
                                }
                                .referral-letter {
                                    max-width: 800px;
                                    margin: 20px auto;
                                    padding: 30px;
                                    font-family: Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                    background: white;
                                }

                                /* List Styling */
                                .referral-letter ul {
                                    list-style-type: none;
                                    padding: 0;
                                    margin: 0;
                                }

                                .referral-letter li {
                                    margin-bottom: 1.2em;
                                    padding-bottom: 0.8em;
                                    border-bottom: 1px solid #eee;
                                }

                                /* Last list item shouldn't have a border */
                                .referral-letter li:last-child {
                                    border-bottom: none;
                                }

                                /* Strong tags (labels) */
                                .referral-letter strong {
                                    display: inline-block;
                                    min-width: 180px;
                                    color: #2c3e50;
                                    font-weight: 600;
                                }

                                /* Print-specific styles */
                                @media print {
                                    .referral-letter {
                                        margin: 0;
                                        padding: 20px;
                                        box-shadow: none;
                                    }
                                    
                                    /* Ensure page breaks don't occur within list items */
                                    .referral-letter li {
                                        page-break-inside: avoid;
                                    }
                                    
                                    /* Improve text contrast for printing */
                                    .referral-letter strong {
                                        color: #000;
                                    }
                                }
                                    </style>
                                </head>
                                <body>
                                    <div>
                                        <h4>
                                            Prescription
                                        </h4>
                                    </div>
                                    <div class="patient">${patientDetails}</div>
                                    <div class="referral-letter">
                                    ${prescriptionContent}
                                    </div>
                                </body>
                                </html>
                            `);
                                                printWindow.document.close();
                                                printWindow.focus();
                                                printWindow.print();
                                                printWindow.close();
                                            });
                                        </script>
                                    @else
                                        <p>No prescription available...</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Medication -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingMedication">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseMedication" aria-expanded="false"
                                    aria-controls="collapseMedication">
                                    Referral Letter
                                </button>
                            </h2>
                            <div id="collapseMedication" class="accordion-collapse collapse"
                                aria-labelledby="headingMedication" data-bs-parent="#dashboardAccordion">
                                <div class="accordion-body">
                                    @if ($referral)
                                        <div class="referral-letter">
                                            <p>Referred on: <strong>{{ $referral->updated_at ?? 'N/A' }}</strong></p>
                                            <ul>
                                                <li><strong>Summary History:
                                                    </strong>{{ $referral?->data?->summaryHistory ?? 'N/A' }}</li>
                                                <li><strong>Differential Diagnosis:
                                                    </strong>{{ $referral?->data?->differentialDiagnosis ?? 'N/A' }}</li>
                                                <li><strong>Reasons for Referral:
                                                    </strong>{{ $referral?->data?->reasonsForReferral ?? 'N/A' }}</li>
                                                <li><strong>Referred To:
                                                    </strong>{{ $referral?->data?->referredTo ?? 'N/A' }}</li>
                                            </ul>
                                        </div>
                                        <div><button class="btn btn-outline-success mt-4"
                                                id="printReferralButton">Print</button></div>
                                        <script>
                                            const printReferralButton = document.getElementById('printReferralButton');
                                            printReferralButton.addEventListener('click', () => {
                                                console.log("Print referral button clicked");
                                                const printWindow = window.open('', '_blank');
                                                const referralLetterContent = document.querySelector('.referral-letter').innerHTML;
                                                const patientDetails = document.querySelector('.toReferral').innerHTML;
                                                printWindow.document.write(`
                                <html>
                                <head>
                                    <title>Referral Letter</title>
                                    <style>
                                    body {
                                    font-family: sans-serif;
                                    margin: 0;
                                }
                                .referral-letter {
                                    max-width: 800px;
                                    margin: 20px auto;
                                    padding: 30px;
                                    font-family: Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                    background: white;
                                }

                                /* List Styling */
                                .referral-letter ul {
                                    list-style-type: none;
                                    padding: 0;
                                    margin: 0;
                                }

                                .referral-letter li {
                                    margin-bottom: 1.2em;
                                    padding-bottom: 0.8em;
                                    border-bottom: 1px solid #eee;
                                }

                                /* Last list item shouldn't have a border */
                                .referral-letter li:last-child {
                                    border-bottom: none;
                                }

                                /* Strong tags (labels) */
                                .referral-letter strong {
                                    display: inline-block;
                                    min-width: 180px;
                                    color: #2c3e50;
                                    font-weight: 600;
                                }

                                /* Print-specific styles */
                                @media print {
                                    .referral-letter {
                                        margin: 0;
                                        padding: 20px;
                                        box-shadow: none;
                                    }
                                    
                                    /* Ensure page breaks don't occur within list items */
                                    .referral-letter li {
                                        page-break-inside: avoid;
                                    }
                                    
                                    /* Improve text contrast for printing */
                                    .referral-letter strong {
                                        color: #000;
                                    }
                                }
                                    </style>
                                </head>
                                <body>
                                    <div>
                                        <h4>
                                            Referral Letter
                                        </h4>
                                    </div>
                                    <div class="patient">${patientDetails}</div>
                                    <div class="referral-letter">
                                    ${referralLetterContent}
                                    </div>
                                </body>
                                </html>
                            `);
                                                printWindow.document.close();
                                                printWindow.focus();
                                                printWindow.print();
                                                printWindow.close();
                                            });
                                        </script>
                                    @else
                                        <p>No Referral Letter available...</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Review Button -->
                <div class="text-center review-btn">
                    <button class="btn btn-primary" id="generateInvoiceBtn"
                        data-registration-number="{{ $child->registration_number }}">
                        Generate Invoice
                    </button>
                </div>
                <script>
                    document.querySelector('.btn-primary').addEventListener('click', async function() {
                        const registrationNumber =
                        '{{ $child->registration_number }}'; // Use Blade to dynamically pass registration number
                        const encodedRegistrationNumber = encodeURIComponent(
                        registrationNumber); // Encode the registration number

                        try {
                            const response = await fetch(`/invoice/${encodedRegistrationNumber}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                            });

                            const data = await response.json();

                            if (response.ok && data.message === 'Invoice generated successfully') {
                                // Invoice generated successfully
                                alert(`Invoice generated for Registration Number: ${registrationNumber}`);
                            } else if (data.message === 'No visit for today') {
                                // No visits for today
                                alert('No visit for today');
                            } else {
                                // Handle other cases
                                alert(data.message || 'Unexpected response from the server.');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error fetching records. Please try again.');
                        }
                    });
                </script>
            @else
                <p>Search for patient in the Search Component above</p>
            @endif
        </div>

    @endsection
