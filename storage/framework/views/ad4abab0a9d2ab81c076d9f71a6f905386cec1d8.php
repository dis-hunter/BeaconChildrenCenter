<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapy Dashboard</title>
    <style>
        .sidebar {
            width: 200px;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 0px;
        }

        .toggle-button {
            position: fixed;
            left: 200px;
            top: 20px;
            background-color: #111827;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 0 6px 6px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: left 0.3s ease;
            z-index: 1000;
        }

        .toggle-button.collapsed {
            left: 60px;
        }

        .toggle-button::before {
            content: "◀";
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .toggle-button.collapsed::before {
            transform: rotate(180deg);
        }

        .main {
            margin-left: 200px;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: 60px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="m-0 font-sans bg-gray-50">
    <div class="sidebar h-screen fixed left-0 top-0 bg-gradient-to-b from-sky-100 to-sky-200 overflow-x-hidden pt-5 transition-all duration-300 border-r border-sky-300 shadow-lg" id="sidebar">
        <div class="p-5 mb-6 bg-white/50 backdrop-blur-sm mx-3 rounded-lg shadow-sm">
            <h2 class="text-gray-800 text-center font-semibold">
                <i class="fas fa-user-md text-2xl text-blue-600 mb-2"></i>
                <div class="text-sm text-gray-600">Active Patient</div>
                <div class="text-lg text-blue-600 font-bold mt-1">John Michael Doe</div>
            </h2>
        </div>

        <a href="#" class="px-4 py-3 text-gray-700 block transition-all duration-300 hover:bg-white/50 hover:text-blue-600 hover:pl-6 flex items-center space-x-3">
            <i class="fas fa-comments"></i>
            <span>Multidisciplinary Communication</span>
        </a>
        <a href="#" class="px-4 py-3 text-gray-700 block transition-all duration-300 hover:bg-white/50 hover:text-blue-600 hover:pl-6 flex items-center space-x-3">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>

    <div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

    <div class="main ml-64 p-8" id="main">
        <div class="container mx-auto" id="mainContent">
            <!-- Form will be inserted here by JavaScript -->
        </div>
    </div>

    <div class="fixed right-5 top-20 bg-white rounded-lg shadow-lg overflow-hidden" id="floatingMenu">
        <div class="bg-gradient-to-r from-blue-500 to-sky-500 text-white py-3 px-4 font-semibold">
            Navigation Menu
        </div>
       
        <button 
   onclick="goToWorkspace()" 
   class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600">
   Therapist Workstation
</button>


      

    <button id="menuButton" class="fixed right-5 top-5 bg-gradient-to-r from-blue-500 to-sky-500 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2">
        <i class="fas fa-bars"></i>
        <span>Menu</span>
    </button>

    <script>
        
        // starts here
          function extractRegistrationCode() {
    const url = window.location.pathname; // Get the current URL path
    const match = url.match(/\/([A-Z]+\-\d+)/); // Use regex to match the pattern
    return match ? match[1] : null; // Return the matched code or null if no match
}

async function goToWorkspace() {
    const registrationNumber = extractRegistrationCode(); // Function to extract registration number
    const specializationId = document.getElementById('specialization_id').value; // Function to retrieve the specialization_id (implement this logic)
    // const specializationId = 2; // Function to retrieve the specialization_id (implement this logic)
    console.log(specializationId);

    try {
        // Perform redirection based on specialization_id
        if (specializationId == 2) {
            window.location.href = `/occupational_therapist/${registrationNumber}`;
        } else if (specializationId ==5) {
            window.location.href = `/nutritionist_therapist/${registrationNumber}`;
        }  else if (specializationId ==3) {
            window.location.href = `/speech_therapist/${registrationNumber}`;
        
        } else if (specializationId ==4) {
            window.location.href = `/physiotherapist/${registrationNumber}`;
        
        }
        else {
            alert('Unauthorized specialization. Access denied.');
        }
    } catch (error) {
        console.error('Error navigating to workspace:', error);
        alert('Error accessing workspace. Please try again.');
    }
}

// ends here
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const toggleButton = document.getElementById('toggle-button');
            
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            toggleButton.classList.toggle('collapsed');
        }

        document.addEventListener("DOMContentLoaded", function() {
            function showHomeForm() {
                const mainContent = document.querySelector('#mainContent');
                mainContent.innerHTML = `
                    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-sky-500 px-6 py-4">
                            <h1 class="text-white text-xl font-semibold">Patient Information</h1>
                        </div>
                        <form id="patient-form" class="p-6 space-y-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                            <input type="hidden" id="child_id" name="child_id" value="<?php echo e($child_id); ?>">
                                            <input type="hidden" id="specialization_id" name="specialization_id" value="<?php echo e($specialization_id); ?>">


                                    <label class="block text-sm font-medium text-gray-700" for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="firstName" value="<?php echo e($firstName); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="middleName">Middle Name</label>
                                    <input type="text" id="middleName" name="middleName" value="<?php echo e($middleName); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" value="<?php echo e($lastName); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="dob">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" value="2018-02-28" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="genderAge">Gender/Age</label>
                                    <input type="text" id="genderAge" name="genderAge" value="male/3yrs" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="hnu">HNU</label>
                                    <input type="text" id="hnu" name="hnu" value="123456" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="mothersName">Mother's Name</label>
                                    <input type="text" id="mothersName" name="mothersName" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="motherTel">Tel</label>
                                    <input type="tel" id="motherTel" name="motherTel" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="motherEmail">Email</label>
                                    <input type="email" id="motherEmail" name="motherEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="fathersName">Father's Name</label>
                                    <input type="text" id="fathersName" name="fathersName" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="fatherTel">Tel</label>
                                    <input type="tel" id="fatherTel" name="fatherTel" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="fatherEmail">Email</label>
                                    <input type="email" id="fatherEmail" name="fatherEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="informant">Informant</label>
                                <input type="text" id="informant" name="informant" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="bg-sky-50 p-6 rounded-lg space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="date">Date</label>
                                <input type="date" id="date" name="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="bg-sky-50 p-6 rounded-lg space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="doctorsNotes">Doctor's Notes</label>
                                <textarea id="doctorsNotes" name="doctorsNotes" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-h-[100px] resize-y"><?php echo e($doctorsNotes); ?></textarea>
                            </div>

                            <div class="bg-sky-50 p-6 rounded-lg space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="createdBy">Created By</label>
                                <input type="text" id="createdBy" name="createdBy" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-sky-500 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300" onclick="CompletedVisit()">Save</button>
                            </div>
                        </form>
                    </div>
                `;
            }

            const homeLink = document.getElementById('homeLink');
            if (homeLink) {
                homeLink.addEventListener('click', showHomeForm);
            }

            showHomeForm();
        });
        async function CompletedVisit() {
    try {
        const childIdElement = document.getElementById('child_id');
        const doctorNotesElement = document.getElementById('doctorsNotes');

        if (!childIdElement) {
            throw new Error('Child ID element not found');
        }

        const childId = childIdElement.value;
        const doctorNotes = doctorNotesElement ? doctorNotesElement.value : '';

        // Save the doctor's notes
        const response = await fetch('/saveDoctorNotes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                child_id: childId,
                notes: doctorNotes
            })
        });

        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            alert(result.message);
            window.location.href = `/therapist_dashboard`;

        } else {
            throw new Error(result.message || 'Failed to save notes');
        }

    } catch (error) {
        console.error('Error:', error);
        alert(`Error: ${error.message}`);
    }
}

// Get the menu button and the floating menu elements
const menuButton = document.getElementById('menuButton');
const floatingMenu = document.getElementById('floatingMenu');

// Function to hide the menu
// function hideMenu() {
//   floatingMenu.style.display = 'none';
// }

// Add a click event listener to the button to toggle the menu
menuButton.addEventListener('click', (event) => {
  // Prevent the click event from propagating to the document
  event.stopPropagation(); 

  if (floatingMenu.style.display === 'none') {
    floatingMenu.style.display = 'block';
  } else {
    floatingMenu.style.display = 'block';
  }
});

// Add a click event listener to the document to hide the menu
document.addEventListener('click', (event) => {
  if (!menuButton.contains(event.target) && !floatingMenu.contains(event.target)) {
    hideMenu();
  }
});

// Add a click event listener to the menu itself to prevent hiding when clicking inside
floatingMenu.addEventListener('click', (event) => {
  event.stopPropagation(); 
});
    
    </script>
    <script src="<?php echo e(asset('js/doctor.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/therapists/occupationaltherapyDashboard.blade.php ENDPATH**/ ?>