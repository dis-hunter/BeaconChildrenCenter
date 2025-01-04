<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Occupational Therapist Session Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .tab-button.active {
            color: #1a202c;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            border-bottom: 2px solid #2563eb;
            background-color: #fff;
        }
        
        .tabs-content {
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
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-blue-800 mb-6">Occupational Therapy</h1>
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Session Documentation</h2>
                <button 
                    onclick="handleGenerateReport()"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Generate Report
                </button>
            </div>
            
            <div class="p-4">
                <form id="therapy-form" class="space-y-4" onsubmit="handleSubmit(event)">
                    <input 
                        type="date" 
                        id="session_date"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        onchange="handleDateChange(event)"
                    />
                    <!--Tabs buttons-->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-4">
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="goals" onclick="showTabContent('goals')">Therapy Goals</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="individualPlanAndStrategies" onclick="showTabContent('individualPlanAndStrategies')">Individualized Plan & Strategies</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="session" onclick="showTabContent('session')">Therapy Session Notes</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="therapyAssessment" onclick="showTabContent('therapyAssessment')">Therapy Assessment</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="followup" onclick="showTabContent('followup')">Follow-up</button>
                        </nav>
                    </div>
                    <!-- Goal Tabs-->
                    <div class="mt-4">
                        <div id="goals" class="tabs-content space-y-4 p-4">
                            @foreach(['Activities of Daily Living(ADLs)', 'Instrumental Activities of Daily Living(IADLs)', 'Fine and Gross Motor Skills','Sensory Integration and Processing' ,'Cognitive Skills', 'Emotional and Social Skills', 'School goals','Rehabilitation goals'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                        class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="goals_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveTherapyGoals()">Save Goals</button>


                        </div>
                        <!-- Individual Plan and Strategies Tab-->
                        <div id="individualPlanAndStrategies" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Therapy frequency and Duration', 'Therapy Setting', 'Gross Motor Skills', 'Fine Motor Skills', 'Cognitive skills', 'Activity of Daily Living','Sensory Integration and Processing','Behaviour Management','Parent involvement/training'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                    class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="goal_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveIndividualised()">Save individualised plan and strategies</button>

                        </div>
                        <!-- Session Notes Tab-->
                        <div id="session" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Gross Motor Skills', 'Fine Motor Skills', 'Cognitive Skills', 'Activity of Daily Living', 'Sensory Integration And Processing','Provide Guidance','Planned Home based tasks'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                        class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="preparation_{{ $category }}"
                                        onchange="handleChange('preparation', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveSession()">Save Session</button>
                        </div>
                        <!-- Therapy Assessment Tab-->
                        <div id="therapyAssessment" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Gross Motor Skills', 'Fine Motor Skills', 'Cognitive Skills', 'Activity of Daily Living', 'Sensory Processing','Behaviour Challenges'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                        class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="assessment_{{ $category }}"
                                        onchange="handleChange('preparation', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveAssessment()">Save Therapy Assessment</button>
                        </div>

                        <div id="followup" class="tabs-content space-y-4 p-4 hidden">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Home Practice Assignments</label>
                                <textarea 
                                    class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    id="followup_home_practice"
                                    onchange="handleChange('followup', 'home_practice', event)"
                                ></textarea>
                            </div>
                            <button type="button" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="saveFollowUp()">Save Follow-up</button>
                        </div>
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
        async function saveTherapyGoals() {
    const categories = [
        'Activities of Daily Living(ADLs)',
        'Instrumental Activities of Daily Living(IADLs)',
        'Fine and Gross Motor Skills',
        'Sensory Integration and Processing',
        'Cognitive Skills',
        'Emotional and Social Skills',
        'School goals',
        'Rehabilitation goals'
    ];

    const goalsData = {};

    // Collect data from the textareas
    categories.forEach(category => {
        const textarea = document.getElementById(`goals_${category}`);
        if (textarea) {
            goalsData[category] = textarea.value.trim(); // Store each category's value as key-value pair
        }
    });

    // Prepare the full payload with other required attributes
    const payload = {
        child_id: 1, // Replace with the actual element ID or logic
        staff_id: 8, // Replace with the actual element ID or logic
        therapy_id:1, // Replace with the actual element ID or logic
        data: goalsData // Add the collected categories data as a JSON object
    };

    try {
        // Make the POST request
        const response = await fetch('/saveTherapyGoal', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error response:', errorText);
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        console.log('Response from server:', result);

        if (result.status === 'success') {
            alert('Therapy goals saved successfully!');
        } else {
            alert('Failed to save therapy goals. Please try again.');
        }
    } catch (error) {
        console.error('Error saving therapy goals:', error);
        alert('An error occurred. Please check the console for more details.');
    }
}


        document.addEventListener('DOMContentLoaded', () => {
            showTabContent('goals'); // Default tab to show
        });
    </script>
        <script>
    async function saveAssessment() {
        const categories = [
            'Gross Motor Skills',
            'Fine Motor Skills',
            'Cognitive Skills',
            'Activity of Daily Living',
            'Sensory Processing',
            'Behaviour Challenges',
        ];

        const assessmentData = {};

        // Collect data from the textareas
        categories.forEach(category => {
            const textarea = document.getElementById(`assessment_${category}`);
            if (textarea) {
                assessmentData[category] = textarea.value.trim(); // Store each category's value as key-value pair
            }
        });

        // Prepare the full payload with other required attributes
        const payload = {
            child_id: 1, // Replace with the actual element ID or logic
            staff_id: 8, // Replace with the actual element ID or logic
            therapy_id: 1, // Replace with the actual element ID or logic
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

    if (!response.ok) {
        const errorText = await response.text();
        console.error('Error response:', errorText);
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();
    console.log('Response from server:', result);

    if (result.status === 'success') {
        alert('Assessment saved successfully!');
    } else {
        alert(`Failed to save assessment: ${result.message}`);
    }
} catch (error) {
    console.error('Error saving assessment:', error);
    alert('An error occurred. Please check the console for more details.');
}
    }
</script>

</body>
</html>