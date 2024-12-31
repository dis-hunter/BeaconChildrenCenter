<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Occupational Therapist Session Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <h1 class="text-3xl font-bold text-center text-blue-600 my-8">Occupational Therapist Session Documentation</h1>
    <div class="max-w-4xl mx-auto p-4 space-y-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Session Documentation</h2>
                <button 
                    onclick="handleGenerateReport()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    <i class="mr-2 h-4 w-4 lucide lucide-file-text"></i>
                    Generate Report
                </button>
            </div>
            <div class="p-4">
                <form id="therapy-form" class="space-y-4" onsubmit="handleSubmit(event)">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <select id="client_id" onchange="handleClientChange(event)" class="w-full p-2 border border-gray-300 rounded">
                                <option value="" disabled selected>Select Client</option>
                                
                                
                                
                            </select>
                        </div>
                        <input 
                            type="date" 
                            id="session_date"
                            class="w-full p-2 border border-gray-300 rounded"
                            onchange="handleDateChange(event)"
                        />
                    </div>

                    <div class="mt-4">
                        <div class="flex border-b border-gray-300">
                            <button type="button" class="py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="goals" onclick="showTabContent('goals')">Goals</button>
                            <button type="button" class="py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="preparation" onclick="showTabContent('preparation')">Therapy Session details</button>
                            <button type="button" class="py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="session" onclick="showTabContent('session')">Session Notes</button>
                            <button type="button" class="py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="followup" onclick="showTabContent('followup')">Follow-up</button>
                        </div>

                        <div id="goals" class="tabs-content active space-y-4 p-4">
                            <?php $__currentLoopData = ['Activities of Daily Living(ADLs)', 'Instrumental Activities of Daily Living(IADLs)', 'Fine and Gross Motor Skills','Sensory Integration and Processing' ,'Cognitive Skills', 'Emotional and Social Skills', 'School or Work-Related ','Rehabilitation Goals']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <h3 class="text-sm font-medium mb-2"><?php echo e($category); ?></h3>
                                    <textarea 
                                        placeholder="Document progress for <?php echo e($category); ?>" 
                                        class="w-full h-24 p-2 border border-gray-300 rounded"
                                        id="goals_<?php echo e($category); ?>"
                                        onchange="handleChange('goals', '<?php echo e($category); ?>', event)"
                                    ></textarea>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div id="preparation" class="tabs-content space-y-4 p-4 hidden">
                            <div>
                                <h3 class="text-sm font-medium mb-2">Preparation(Before the Session)</h3>
                                <textarea 
                                    placeholder="Review client records,set objectives, and prepare materials" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="preparation_client_records"
                                    onchange="handleChange('preparation', 'client_records', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Introduction(5-10 minutes)</h3>
                                <textarea 
                                    placeholder="Greet and build rapport,review goals,warm-up" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="preparation_objectives"
                                    onchange="handleChange('preparation', 'objectives', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Main Activity(20-30 minutes)</h3>
                                <textarea 
                                    placeholder="Motor skills, cognitive skills, social skills, etc." 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="preparation_materials"
                                    onchange="handleChange('preparation', 'materials', event)"
                                ></textarea>
                                <h3 class="text-sm font-medium mb-2">Cool Down(5-10 minutes)</h3>
                                <textarea 
                                    placeholder="Reflect on Activities,Relaxation Technidues,Feeback" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="preparation_materials"
                                    onchange="handleChange('preparation', 'materials', event)"
                                ></textarea>
                                <h3 class="text-sm font-medium mb-2">Closing(5 minutes)</h3>
                                <textarea 
                                    placeholder="Set homework or practice tasks,plan next session,encouragement" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="preparation_materials"
                                    onchange="handleChange('preparation', 'materials', event)"
                                ></textarea>
                            </div>
                        </div>

                        <div id="session" class="tabs-content space-y-4 p-4 hidden">
                            <div>
                                <h3 class="text-sm font-medium mb-2">Record the client's performance,challenges and progress</h3>
                                <textarea 
                                    placeholder="Client Record Details" 
                                    class="w-full h-32 p-2 border border-gray-300 rounded"
                                    id="session_activities"
                                    onchange="handleChange('session', 'activities', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Adjustments needed for future sessions</h3>
                                <textarea 
                                    placeholder="Future Sessions Plans" 
                                    class="w-full h-32 p-2 border border-gray-300 rounded"
                                    id="session_client_response"
                                    onchange="handleChange('session', 'client_response', event)"
                                ></textarea>
                            </div>
                        </div>

                        <div id="followup" class="tabs-content space-y-4 p-4 hidden">
                            <div>
                                <h3 class="text-sm font-medium mb-2">Home Practice Assignments</h3>
                                <textarea 
                                    placeholder="Document assigned activities for practice at home" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="followup_home_practice"
                                    onchange="handleChange('followup', 'home_practice', event)"
                                ></textarea>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium mb-2">Next Session Plan</h3>
                                <textarea 
                                    placeholder="Document plans and focus areas for next session" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="followup_next_plan"
                                    onchange="handleChange('followup', 'next_plan', event)"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
               ADLs : '',
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
        }

        document.addEventListener('DOMContentLoaded', () => {
            showTabContent('goals');
        });
    </script>
</body>
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/therapists/occupationalTherapist.blade.php ENDPATH**/ ?>