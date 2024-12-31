<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Occupational Therapist Session Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        
        .tab-button.active {
    color: #1a202c; 
    box-shadow: 2px 2px 2px 2px  black;
    border:2px solid black;
    
}
     </style>   
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
                        
                        <input 
                            type="date" 
                            id="session_date"
                            class="w-full p-2 border border-gray-300 rounded"
                            onchange="handleDateChange(event)"
                        />
                    </div>
                        <!--tab links-->
                    <div class="mt-4">
                        <div class="flex border-b border-gray-300">
                        <button type="button" class="tab-button py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="goals" onclick="showTabContent('goals')">Goals</button>
                        <button type="button" class="tab-button py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="individualPlanAndStrategies" onclick="showTabContent('individualPlanAndStrategies')">Individual therapy plan and strategies</button>
                        <button type="button" class="tab-button py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="therapySession" onclick="showTabContent('therapySession')">Therapy Assesment</button>
                        <button type="button" class="tab-button py-2 px-4 text-gray-600 hover:bg-gray-200" data-value="session" onclick="showTabContent('session')">Session Notes</button>
                        </div>
                    <!--tab content-->
                    <!--Goals tab-->	
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
                        <!--Individual Plan and Strategies tab-->
                        <div id="individualPlanAndStrategies" class="tabs-content space-y-4 p-4 hidden">
                            <?php $__currentLoopData = ['Therapy frequency and Duration', 'Therapy Setting', 'Gross Motor Skills', 'Fine Motor Skills', 'Cognitive skills', 'Activity of Daily Living','Sensory Integration and Processing','Behaviour Management','Parent involvement/training']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <!--Therapy Assesement tab-->
                        <div id="therapySession" class="tabs-content space-y-4 p-4 hidden">
                            <div>
                            <?php $__currentLoopData = ['Gross Motor Skills', 'Fine Motor Skills', 'Cognitive Skills', 'Activity of Daily Living', 'Sensory Processing','Behaviour Challenges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <h3 class="text-sm font-medium mb-2"><?php echo e($category); ?></h3>
                                <textarea 
                                    placeholder="Document progress for <?php echo e($category); ?>" 
                                    class="w-full h-24 p-2 border border-gray-300 rounded"
                                    id="preparation_<?php echo e($category); ?>"
                                    onchange="handleChange('preparation', '<?php echo e($category); ?>', event)"
                                ></textarea>  
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            </div>
                        </div>
                        <!--Session Notes tab-->
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
                        <!--Follow-up tab-->
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
        //function to show tab content and hide others
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
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/therapists/occupationalTherapist.blade.php ENDPATH**/ ?>