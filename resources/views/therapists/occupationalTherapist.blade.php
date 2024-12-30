<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Occupational Therapist Session Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .max-w-4xl {
            max-width: 64rem;
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        .p-4 {
            padding: 1rem;
        }
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            color: #fff;
            cursor: pointer;
        }
        .bg-blue-600 {
            background-color: #2563eb;
        }
        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8;
        }
        .input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }
        .textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }
        .tabs {
            margin-top: 1rem;
        }
        .tabs-list {
            display: flex;
            border-bottom: 1px solid #ddd;
        }
        .tabs-trigger {
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
        .tabs-content {
            display: none;
            padding: 1rem;
        }
        .tabs-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Occupational Therapist Session Documentation</h1>
    <div class="max-w-4xl mx-auto p-4 space-y-4">
        <div class="card">
            <div class="card-header flex flex-row items-center justify-between">
                <h2 class="card-title">Session Documentation</h2>
                <button 
                    onclick="handleGenerateReport()"
                    class="bg-blue-600 hover:bg-blue-700 button"
                >
                    <i class="mr-2 h-4 w-4 lucide lucide-file-text"></i>
                    Generate Report
                </button>
            </div>
            <div class="card-content">
                <form id="therapy-form" class="space-y-4" onsubmit="handleSubmit(event)">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="select">
                            <select id="client_id" onchange="handleClientChange(event)">
                                <option value="" disabled selected>Select Client</option>
                                {{-- @foreach($clients as $client) --}}
                                {{-- <option value="{{ $client->id }}">{{ $client->name }}</option> --}}
                                {{-- @endforeach --}}
                            </select>
                        </div>
                        <input 
                            type="date" 
                            id="session_date"
                            class="input"
                            onchange="handleDateChange(event)"
                        />
                    </div>

                    <div class="tabs" data-default="goals">
                        <div class="tabs-list w-full">
                            <button type="button" class="tabs-trigger" data-value="goals" onclick="showTabContent('goals')">Goals</button>
                            <button type="button" class="tabs-trigger" data-value="preparation" onclick="showTabContent('preparation')">Preparation</button>
                            <button type="button" class="tabs-trigger" data-value="session" onclick="showTabContent('session')">Session Notes</button>
                            <button type="button" class="tabs-trigger" data-value="followup" onclick="showTabContent('followup')">Follow-up</button>
                        </div>

                        <div id="goals" class="tabs-content active space-y-4">
                            @foreach(['ADLs', 'IADLs', 'Motor Skills', 'Cognitive Skills', 'Social Skills'] as $category)
                                <div>
                                    <h3 class="text-sm font-medium mb-2">{{ $category }}</h3>
                                    <textarea 
                                        placeholder="Document progress for {{ $category }}" 
                                        class="h-24 textarea"
                                        id="goals_{{ $category }}"
                                        onchange="handleChange('goals', '{{ $category }}', event)"
                                    ></textarea>
                                </div>
                            @endforeach
                        </div>

                        <div id="preparation" class="tabs-content space-y-4">
                            <div>
                                <h3 class="text-sm font-medium mb-2">Client Records Review</h3>
                                <textarea 
                                    placeholder="Document medical history review and previous session outcomes" 
                                    class="h-24 textarea"
                                    id="preparation_client_records"
                                    onchange="handleChange('preparation', 'client_records', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Session Objectives</h3>
                                <textarea 
                                    placeholder="List specific objectives for today's session" 
                                    class="h-24 textarea"
                                    id="preparation_objectives"
                                    onchange="handleChange('preparation', 'objectives', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Materials Required</h3>
                                <textarea 
                                    placeholder="Document required equipment and materials" 
                                    class="h-24 textarea"
                                    id="preparation_materials"
                                    onchange="handleChange('preparation', 'materials', event)"
                                ></textarea>
                            </div>
                        </div>

                        <div id="session" class="tabs-content space-y-4">
                            <div>
                                <h3 class="text-sm font-medium mb-2">Activities Conducted</h3>
                                <textarea 
                                    placeholder="Document activities and interventions" 
                                    class="h-32 textarea"
                                    id="session_activities"
                                    onchange="handleChange('session', 'activities', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Client Response</h3>
                                <textarea 
                                    placeholder="Document client's performance and engagement" 
                                    class="h-32 textarea"
                                    id="session_client_response"
                                    onchange="handleChange('session', 'client_response', event)"
                                ></textarea>
                            </div>
                        </div>

                        <div id="followup" class="tabs-content space-y-4">
                            <div>
                                <h3 class="text-sm font-medium mb-2">Home Practice Assignments</h3>
                                <textarea 
                                    placeholder="Document assigned activities for practice at home" 
                                    class="h-24 textarea"
                                    id="followup_home_practice"
                                    onchange="handleChange('followup', 'home_practice', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Next Session Plan</h3>
                                <textarea 
                                    placeholder="Document plans and focus areas for next session" 
                                    class="h-24 textarea"
                                    id="followup_next_plan"
                                    onchange="handleChange('followup', 'next_plan', event)"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full button">
                        Save Session
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
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
                content.classList.remove('active');
            });
            document.getElementById(tab).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            showTabContent('goals');
        });
    </script>
</body>
</html>