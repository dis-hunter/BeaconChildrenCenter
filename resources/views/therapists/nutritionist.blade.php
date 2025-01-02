<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritionist Session Documentation</title>
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
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns */
            gap: 20px; 
        }

        .grid-item {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-blue-800 mb-6">Nutritionist</h1>
        
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
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="goals" onclick="showTabContent('goals')">Nutrition Goals</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="individualPlanAndStrategies" onclick="showTabContent('individualPlanAndStrategies')">Individualized Plan & Strategies</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="session" onclick="showTabContent('session')">Nutrition Session Notes</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="therapyAssesment" onclick="showTabContent('therapyAssesment')">Nutrition Assessment</button>
                            <button type="button" class="tab-button px-3 py-2 text-sm font-medium" data-value="followup" onclick="showTabContent('followup')">Follow-up</button>
                        </nav>
                    </div>
                    <!-- Goal Tabs-->
                    <div class="mt-4">
                        <div id="goals" class="tabs-content space-y-4 p-4">
                            @foreach(['Achieve weight loss or gain','Manage micronutrients deficiencies','Reduce digestive issues','Enhance overall energy level
                            and wellness'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                        class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="goals_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                        </div>
                        <!-- Individual Plan and Strategies Tab-->
                        <div id="individualPlanAndStrategies" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Therapy frequency and Duration', 'Therapy Setting', 'Meal Plan', 'Behaviour Management', 'Other Support services', 'Evaluate and Adapt'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                    class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="goals_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                        </div>
                        <!-- Session Notes Tab-->
                        <div id="session" class="tabs-content space-y-4 p-4 hidden">
                            @foreach(['Nutrition education', 'Meal Plan', 'Behaviour strategies','Collaboration with other 
                            professionals','Educate and adapt'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                        class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="preparation_{{ $category }}"
                                        onchange="handleChange('preparation', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                        </div>
                        <!-- Nutrition Assessment Tab-->
                        <div id="therapyAssesment" class="tabs-content space-y-4 p-4 hidden">
                            <div class="grid-container">
                                @foreach(['Weight(kg)', 'Weight for Age', 'Height(cm)', 'Height for Age', 'Head circumference','Weight for Height','BMI','MUAC(cm)','Girth circumference'] as $category)
                                    <div class="grid-item mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                        <textarea 
                                            class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                            id="preparation_{{ $category }}"
                                            onchange="handleChange('preparation', '{{ $category }}', event)"
                                        ></textarea> 
                                    </div>
                                @endforeach
                            </div>
                            @foreach(['Medical Problems', 'Dietry Intake', 'Lifestyle factors', 'Psychosocial/Behavioural factors', 'Biochemical Data'] as $category)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category }}</label>
                                    <textarea 
                                        class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                        id="preparation_{{ $category }}"
                                        onchange="handleChange('preparation', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                        </div>
                        <!-- Follow-up Tab-->
                        <div id="followup" class="tabs-content space-y-4 p-4 hidden">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Home Practice Assignments</label>
                                <textarea 
                                    class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    id="followup_home_practice"
                                    onchange="handleChange('followup', 'home_practice', event)"
                                ></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Next Session Plan</label>
                                <textarea 
                                    class="w-full h-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    id="followup_next_plan"
                                    onchange="handleChange('followup', 'next_plan', event)"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Session
                    </button>
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
            showTabContent('goals'); // Default tab to show
        });
    </script>
</body>
</html>