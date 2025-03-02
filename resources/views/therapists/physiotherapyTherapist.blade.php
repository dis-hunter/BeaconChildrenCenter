<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Physiotherapy Therapist Session Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .tab-button.active {
            color: #1a202c;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            border-bottom: 2px solid #2563eb;
            background-color: #fff;
        }
        
        /* .tabs-content {
            max-height: 60vh;
            overflow-y: auto;
            scrollbar-width: thin;
        }
        
        .tabs-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .tabs-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .tabs-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        } */
    </style>
</head>
<body class="bg-gray-50">
     <!-- Add Back and Next buttons -->
     <button id="backButton" onclick="NavigateBack()"class="px-4 py-2 bg-gray-300 rounded">◀Back</button>

    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-blue-800 mb-6">Physiotherapy</h1>
        <div class="flex items-center w-full px-3 py-2 border border-gray-300 text-blue-900 rounded-md">
    <span class="text-black font-medium mr-2">Patient Name:</span>
        <input type="text" id="fullName" name="fullName" value="{{ $firstName }} {{ $middleName }} {{ $lastName }}">        <input   type="hidden" id="child_id" name="child_id" value="{{ $child_id }}">
</div>
        <input   type="hidden" id="child_id" name="child_id" value="{{ $child_id }}">
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Session Documentation</h2>
                <button 
                    onclick="handleGenerateReport()"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Generate Report
                </button>
            </div> -->
            
            <div class="p-4">
                <form id="therapy-form" class="space-y-4" onsubmit="handleSubmit(event)">
                    <!-- <input 
                        type="date" 
                        id="session_date"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        onchange="handleDateChange(event)"
                    /> -->
                    <!--Tabs buttons-->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-4">
                        <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="therapyAssesment" onclick="showTabContent('therapyAssesment')">Therapy Assessment</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="goals" onclick="showTabContent('goals')">Therapy Goals</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="individualPlanAndStrategies" onclick="showTabContent('individualPlanAndStrategies')">Individualized Plan & Strategies</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="session" onclick="showTabContent('session')">Therapy Session Notes</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="followup" onclick="showTabContent('followup')">Post Session Activities</button>
                        </nav>
                    </div>
                     <!-- Therapy Assessment Tab-->
                     <div id="therapyAssesment" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Gross Motor Skills', 'Fine Motor Skills', 'Family Assessment','Cognitive Skills', 'Activity of Daily Living', 'Sensory Processing','Behaviour Challenges','Orthotics','Assistive devices'] as $category)
                            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
            <textarea 
                class="form-control"
                style="width: 100%; height: 10px; resize: vertical; overflow: hidden; border: 1px solid #ccc; border-radius: 4px; padding: 8px;"
                id="assessment_{{ $category }}"
                onchange="handleChange('preparation', '{{ $category }}', event)"
            ></textarea>
        </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveAssessment()">Save Therapy Assessment</button>
                        </div>
                    <!-- Goal Tabs-->
                    <div class="mt-4">
                        <div id="goals" class="tabs-content space-y-4 p-4">
                            @foreach(['Activities of Daily Living(ADLs)', 'Instrumental Activities of Daily Living(IADLs)', 'Fine and Gross Motor Skills','Sensory Integration and Processing' ,'Cognitive Skills', 'Emotional and Social Skills', 'School goals','Rehabilitation goals'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                class="form-control"
                style="width: 100%; height: 10px; resize: vertical; overflow: hidden; border: 1px solid #ccc; border-radius: 4px; padding: 8px;" 
                                        id="goals_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveTherapyGoals()">Save Goals</button>
                        </div>
                        <!-- Individual Plan and Strategies Tab-->
                        <div id="individualPlanAndStrategies" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Therapy frequency and Duration', 'Therapy Setting/Resources', 'Strengthening excercises', 'Balance Training', 'Gait Training', 'Sensory simulation','Parent involvement/training','Assistive Devices'] as $category)
                            <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                class="form-control"
                style="width: 100%; height: 10px; resize: vertical; overflow: hidden; border: 1px solid #ccc; border-radius: 4px; padding: 8px;"
                                        id="individualized_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveIndividualized()">Save individualized plan and strategies</button>

                        </div>
                        <!-- Session Notes Tab-->
                        <div id="session" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Targeted excercises', 'Manual therapy', 'Functional Training', 'Gait training', 'Sensory Integration And Processing','Stretching and range of motion','Monitor Progress','Planned home based tasks'] as $category)
                            <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                    <textarea 
                class="form-control"
                style="width: 100%; height: 10px; resize: vertical; overflow: hidden; border: 1px solid #ccc; border-radius: 4px; padding: 8px;"
                                        id="session_{{ $category }}"
                                        onchange="handleChange('preparation', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveSession()">Save Session</button>
                        </div>
                        <!-- Follow-up Tab-->
                        <div id="followup" class="tabs-content space-y-4 p-4 hidden">
                        @foreach(['Home Practice Assignments', 'Next Session Plan'] as $category)
                        <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                class="form-control"
                style="width: 100%; height: 10px; resize: vertical; overflow: hidden; border: 1px solid #ccc; border-radius: 4px; padding: 8px;"
                                        id="followup_{{ $category }}"
                                        onchange="handleChange('preparation', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <!-- Multi-date picker -->
    <label class="block text-sm font-medium text-gray-700 mt-2">Select return Date(s)</label>
            <div id="date-picker-container_{{ $category }}">
                <input 
                    type="text" 
                    class="multi-date-picker form-control border rounded px-2 py-1 mb-2" 
                    id="dates_{{ $category }}" 
                    onchange="handleDatesChange('dates', '{{ $category }}', event)" 
                    placeholder="Select multiple dates" 
                />
            </div>
            <button type="button" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="addDatePicker('{{ $category }}')">Add Another Date</button>
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveFollowup()">Save Post Session Activities</button>
                            </div>
                            <script>
    // Initialize Flatpickr for multi-date selection
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.multi-date-picker').forEach(function (input) {
            flatpickr(input, {
                mode: 'multiple', // Allow multiple date selection
                dateFormat: 'Y-m-d', // Format dates as desired
            });
        });
    });

    // Handle changes in selected dates
    function handleDatesChange(type, category, event) {
        const selectedDates = event.target.value;
        console.log(`Selected dates for ${category}:`, selectedDates);
        // Add logic to save or process these dates as needed
    }

    // Add another date picker
    function addDatePicker(category) {
        const container = document.getElementById(`date-picker-container_${category}`);
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'multi-date-picker form-control border rounded px-2 py-1 mb-2';
        input.placeholder = 'Select multiple dates';
        input.onchange = function(event) {
            handleDatesChange('dates', category, event);
        };
        container.appendChild(input);
        flatpickr(input, {
            mode: 'multiple',
            dateFormat: 'Y-m-d',
        });
    }
</script>
<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript remains unchanged
        let formData = {
            client_id: '',
            session_date: '',
            goals: {
                ADLs: '',
                IADLs: '',
                'Motor Skills': '',
                'Cognitive Skills': '',
                'Social Skills': ''
            },
            preparation: {
                client_records: '',
                objectives: '',
                materials: ''
            },
            session: {
                activities: '',
                client_response: ''
            },
            followup: {
                home_practice: '',
                next_plan: ''
            }
        };

        function handleClientChange(event) {
            formData.client_id = event.target.value;
        }

        function handleDateChange(event) {
            formData.session_date = event.target.value;
        }

        function handleChange(section, field, event) {
            formData[section][field] = event.target.value;
        }

        async function handleGenerateReport() {
            try {
                const response = await fetch('/api/therapy-sessions/report', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                if (response.ok) {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `therapy-report-${formData.session_date}.pdf`;
                    a.click();
                }
            } catch (error) {
                console.error('Error generating report:', error);
            }
        }

        async function handleSubmit(event) {
            event.preventDefault();
            try {
                const response = await fetch('/api/therapy-sessions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                if (response.ok) {
                    // Handle success
                }
            } catch (error) {
                console.error('Error saving session:', error);
            }
        }

        function showTabContent(tab) {
            document.querySelectorAll('.tabs-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            document.getElementById(tab).classList.remove('hidden');
            document.getElementById(tab).classList.add('active');

            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`[data-value="${tab}"]`).classList.add('active');
        }
       
        document.addEventListener('DOMContentLoaded', () => {
            showTabContent('therapyAssesment'); // Default tab to show
            	
        });
    </script>
        <script src="{{ asset('js/loader.js') }}"></script> 
        <script src="{{asset('js/backAndNextButton.js')}}"></script>
   
        <script src="{{ asset('js/movement.js')}}"></script>   
    <script>
        const childId = document.getElementById('child_id').value;

     // handles submission of goals to db
     async function saveTherapyGoals() {
 
    showLoadingIndicator('Saving...', 0);

    const categories = [
        'Activities of Daily Living(ADLs)',
        'Fine and Gross Motor Skills',
        'Sensory Integration and Processing',
        'Cognitive Skills',
        'School goals',
        'Rehabilitation goals',
        'Assistive devices'
    ];

  

    const goalsData = {};

    // Collect data from the textareas
    categories.forEach(category => {
        const textarea = document.getElementById(`goals_${category}`);
        if (textarea) {
            goalsData[category] = textarea.value.trim();
            
        } else {
            console.warn(`Step 4: Warning - No textarea found for category: ${category}`);
        }
    });

    // Prepare the full payload
    const payload = {
        child_id: childId, // Replace with actual ID
        staff_id: 1, // Replace with actual staff ID
        therapy_id: 2, // Replace with actual therapy ID
        data: goalsData
    };

 

    try {
        

        const response = await fetch('/saveTherapyGoal', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(payload),
        });

      

        updateLoadingProgress(70, 'Processing...');

        if (!response.ok) {
            const errorText = await response.text();
           
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // Check if response is actually JSON
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
           
            const responseText = await response.text();
          
            throw new Error('Expected JSON but received HTML.');
        }

        const result = await response.json();
       

        updateLoadingProgress(100, 'Almost Complete');
        await new Promise(resolve => setTimeout(resolve, 200));

        if (result.status === 'success') {
           
            alert('Therapy goals saved successfully!');
        } else {
          
            alert('Failed to save therapy goals. Please try again.');
        }
    } catch (error) {
       

        if (error.message.includes('Unexpected token <')) {
         
        }

        alert('An error occurred. Please check the console for more details.');
    } finally {
       
        hideLoadingIndicator();
    }
}




        document.addEventListener('DOMContentLoaded', () => {
            showTabContent('therapyAssesment'); // Default tab to show
        });
    </script>
        <script>
                //pushing data to the db therapy_assessment table
    async function saveAssessment() {
        // 'Gross Motor Skills', 'Fine Motor Skills', 'Cognitive Skills', 'Activity of Daily Living', 
        // 'Sensory Processing','Behaviour Challenges','Orthotics','Assistive devices'] as $category)

        showLoadingIndicator('Saving...', 0);
        const categories = [
            'Gross Motor Skills',
            'Fine Motor Skills',
            'Cognitive Skills',
            'Family Assessment',
            'Activity of Daily Living',
            'Sensory Processing',
            'Behaviour Challenges',
            'Orthotics',
            'Assistive devices',
        ];

        const assessmentData = {};

         // Collect data from the textareas - no delay needed here
         updateLoadingProgress(30, 'Sending data...');
        // Collect data from the textareas
        categories.forEach(category => {
            const textarea = document.getElementById(`assessment_${category}`);
            if (textarea) {
                assessmentData[category] = textarea.value.trim(); // Store each category's value as key-value pair
            }
        });

        // Prepare the full payload with other required attributes
        const payload = {
            child_id: childId, // Replace with the actual element ID or logic
            staff_id: 1, // Replace with the actual element ID or logic
            therapy_id: 2, // Replace with the actual element ID or logic
            data: assessmentData // Add the collected categories data as a JSON object
        };

        try {
    // Make the POST request
    const response = await fetch('/saveAssessment', {
        method: 'POST',
        
headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(payload),
    });
    updateLoadingProgress(70, 'Processing...');

    if (!response.ok) {
        const errorText = await response.text();
        console.error('Error response:', errorText);
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();
   
    
    // Single short delay just to show completion
    updateLoadingProgress(100, 'Almost Complete');
    await new Promise(resolve => setTimeout(resolve, 200));
    
    if (result.status === 'success') {
        alert('Assessment saved successfully!');
    } else {
        alert(`Failed to save assessment: ${result.message}`);
    }
} catch (error) {
    console.error('Error saving assessment:', error);
    alert('An error occurred. Please check the console for more details.');
}finally {
        hideLoadingIndicator();
    }
}
</script>
<script>
    //pushing data to the db therapy_individualized table
    
    async function saveIndividualized() {
        //'Therapy frequency and Duration', 'Therapy Setting', 'Strengthening excercises', 'Balance Training', 'Gait Training',
        //  'Sensory simulation','Parent involvement/training','Assistive Devices'] as $category)

        showLoadingIndicator('Saving...', 0);
        const categories = [        
            'Therapy frequency and Duration',
            'Therapy Setting/Resources',
            'Strengthening excercises',
            'Balance Training',
            'Gait Training',
            'Sensory simulation',
            'Parent involvement/training',
            'Assistive Devices',
        ];

        const individualizedData = {};
        
         // Collect data from the textareas - no delay needed here
         updateLoadingProgress(30, 'Sending data...');
        // Collect data from the textareas
        categories.forEach(category => {
            const textarea = document.getElementById(`individualized_${category}`);
            if (textarea) {
                individualizedData[category] = textarea.value.trim(); // Store each category's value as key-value pair
            }
        });

        // Prepare the full payload with other required attributes
        const payload = {
            child_id: childId, // Replace with the actual element ID or logic
            staff_id: 1, // Replace with the actual element ID or logic
            therapy_id: 2, // Replace with the actual element ID or logic
            data: individualizedData // Add the collected categories data as a JSON object
        };

        try {
    // Make the POST request
    const response = await fetch('/saveIndividualized', {
        method: 'POST',
        
headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(payload),
    });
    
    updateLoadingProgress(70, 'Processing...');


    if (!response.ok) {
        const errorText = await response.text();
        console.error('Error response:', errorText);
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();
    console.log('Response from server:', result);
    
     // Single short delay just to show completion
     updateLoadingProgress(100, 'Almost Complete');
    await new Promise(resolve => setTimeout(resolve, 200));
    if (result.status === 'success') {
        alert('Individualized plans and strategies saved successfully!');
    } else {
        alert(`Failed to save individualized plan and strategies: ${result.message}`);
    }
} catch (error) {
    console.error('Error saving individualized plan and strategies:', error);
    alert('An error occurred. Please check the console for more details.');
}finally {
        hideLoadingIndicator();
    }
}
</script>
<script>
    //pushing data to the db therapy_session table
    //['Gross Motor Skills', 'Fine Motor Skills', 'Cognitive Skills', 'Activity of Daily Living', 
    // 'Sensory Integration And Processing','Provide Guidance','Planned Home based tasks'] as $category)

    
    async function saveSession() {
        // 'Targeted excercises', 'Manual therapy', 'Functional Training', 'Gait training', 'Sensory Integration And Processing',
        // 'Stretching and range of motion','Monitor Progress','Planned home based tasks'] as $category)

        showLoadingIndicator('Saving...', 0);
        const categories = [
            'Targeted excercises',
            'Manual therapy',
            'Functional Training',
            'Gait training',
            'Sensory Integration And Processing',
            'Stretching and range of motion',
            'Monitor Progress',
            'Planned home based tasks',
        ];

        const sessionData = {};
        // Collect data from the textareas - no delay needed here
        updateLoadingProgress(30, 'Sending data...');
        // Collect data from the textareas
        categories.forEach(category => {
            const textarea = document.getElementById(`session_${category}`);
            if (textarea) {
                sessionData[category] = textarea.value.trim(); // Store each category's value as key-value pair
            }
        });

        // Prepare the full payload with other required attributes
        const payload = {
            child_id: childId, // Replace with the actual element ID or logic
            staff_id: 1, // Replace with the actual element ID or logic
            therapy_id: 2, // Replace with the actual element ID or logic
            data: sessionData // Add the collected categories data as a JSON object
        };

        try {
            
    // Make the POST request
    const response = await fetch('/saveSession', {
        method: 'POST',
        
headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(payload),
    });
    updateLoadingProgress(70, 'Processing...');


    if (!response.ok) {
        const errorText = await response.text();
        console.error('Error response:', errorText);
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();
    console.log('Response from server:', result);

    // Single short delay just to show completion
    updateLoadingProgress(100, 'Almost Complete');
    await new Promise(resolve => setTimeout(resolve, 200));
    if (result.status === 'success') {
        alert('Session saved successfully!');
    } else {
        alert(`Failed to save Sessions: ${result.message}`);
    }
} catch (error) {
    console.error('Error saving Session:', error);
    alert('An error occurred. Please check the console for more details.');
}finally {
        hideLoadingIndicator();
    }
}
    
</script>
<script>
    //pushing data to the db follow_up table
    async function saveFollowup() {
    showLoadingIndicator('Saving...', 0);
    const categories = [
        'Home Practice Assignments',
        'Next Session Plan',
        'Dates'
    ];

    const followupData = {};

    try {
        // Collect data from the textareas - no delay needed here
        updateLoadingProgress(30, 'Sending data...');
        
        categories.forEach(category => {
            const textarea = document.getElementById(`followup_${category}`);
            if (textarea) {
                followupData[category] = textarea.value.trim();
            }
        });
        // Collect dates from the date picker
        const datePickers = document.querySelectorAll('.multi-date-picker');
            followupData['Dates'] = [];
            datePickers.forEach(picker => {
                followupData['Dates'].push(picker.value);
            });

        const payload = {
            child_id: childId,
            staff_id: 1,
            therapy_id: 2,
            data: followupData
        };

        // Make the request - natural network delay will occur here
        const response = await fetch('/saveFollowup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(payload),
        });

        updateLoadingProgress(70, 'Processing...');

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error response:', errorText);
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        console.log('Response from server:', result);

        // Single short delay just to show completion
        updateLoadingProgress(100, 'Almost Complete');

        await new Promise(resolve => setTimeout(resolve, 200));

        if (result.status === 'success') {
            alert('Followup saved successfully!');
        } else {
            alert(`Failed to save Followup: ${result.message}`);
        }
    } catch (error) {
        console.error('Error saving Followup:', error);
        alert('An error occurred. Please check the console for more details.');
    } finally {
        hideLoadingIndicator();
    }
}
</script>

<script>
function extractRegistrationCode() {
    const pathSegments = window.location.pathname.split('/');
    return pathSegments[pathSegments.length - 1];
}

function NavigateBack() {
    const RegNo = extractRegistrationCode();
    window.location.href = `/occupationaltherapy_dashboard/${RegNo}`;
    window.location.reload(); // Refresh the previous page
}
</script>
</body>
</html>
</body>
</html>