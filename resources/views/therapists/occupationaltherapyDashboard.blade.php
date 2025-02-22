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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="m-0 font-sans bg-gray-50">
    <div class="sidebar h-screen fixed left-0 top-0 bg-gradient-to-b from-sky-100 to-sky-200 overflow-x-hidden pt-5 transition-all duration-300 border-r border-sky-300 shadow-lg" id="sidebar">
        <div class="p-5 mb-6 bg-white/50 backdrop-blur-sm mx-3 rounded-lg shadow-sm">
            <h2 class="text-gray-800 text-center font-semibold">
                <i class="fas fa-user-md text-2xl text-blue-600 mb-2"></i>
                <div class="text-sm text-gray-600">Active Patient</div>
                <div class="text-lg text-blue-600 font-bold mt-1" id="child-name-div"></div>
            </h2>
        </div>

        <a href="#" class="px-4 py-3 text-gray-700 block transition-all duration-300 hover:bg-white/50 hover:text-blue-600 hover:pl-6 flex items-center space-x-3">
            <i class="fas fa-comments"></i>
            <span>Multidisciplinary Communication</span>
        </a>
       <!-- Loader (Hidden by default) -->
    <div id="loader" class="hidden fixed inset-0 flex items-center justify-center bg-white bg-opacity-75">
        <div class="w-16 h-16 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
    </div>

    <!-- Logout Link -->
    <a href="http://127.0.0.1:8000/login" 
       class="px-4 py-3 text-gray-700 block transition-all duration-300 hover:bg-white/50 hover:text-blue-600 hover:pl-6 flex items-center space-x-3"
       onclick="showLoader(event)">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
    <script>
        function showLoader(event) {
            event.preventDefault(); // Prevent immediate navigation
            showLoadingIndicator('Logging out...', 0);
            showLoadingIndicator('Logging out...', 70);
            


            // Redirect after a short delay to allow loader to show
            setTimeout(() => {
                window.location.href = event.target.closest('a').href;
            }, 1000);
        }
    </script>
    </div>

    <div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

    <div class="main ml-64 p-8" id="main">
        <div class="container mx-auto" id="mainContent">
            <!-- Form will be inserted here by JavaScript -->
        </div>
    </div>

    <!-- Navigation Menu Button -->
<button 
    id="menuButton" 
    class="fixed right-5 top-5 bg-gradient-to-r from-blue-500 to-sky-500 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2"
    onclick="toggleMenu()"
>
    <i class="fas fa-bars"></i>
    <span>Navigation Menu</span>
</button>

<!-- Menu Links -->
<div 
    id="floatingMenu" 
    class="fixed right-5 top-20 bg-white rounded-lg shadow-lg overflow-hidden"
>
<button 
        id="backToDashboardButton"
        onclick="handleBackToDashboardClick()"
        class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600"
    >
        Go back to Dashboard
    </button>
    <button 
    id="backToDashboardButton"
    onclick="handleBackToPatientInfo()"
    class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600"
>
    Go back to patient info
</button>


    <button 
        onclick="goToWorkspace(event)" 
        class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600"
    >
        Therapist Workstation
    </button>

    <button 
        onclick="goToEncounterSummary(event)" 
        class="block px-4 py-3 text-gray-700 border-b border-gray-100 transition-all duration-300 hover:bg-sky-50 hover:text-blue-600"
    >
        Encounter Summary
    </button>
</div>

<script>
    function toggleMenu() {
        const menu = document.getElementById('floatingMenu');
        // Toggle the "hidden" class to show/hide the menu links
        menu.classList.toggle('hidden');
    }
</script>

<style>
    /* Add a "hidden" class to hide the menu links */
    .hidden {
        display: none;
    }
</style>
<script src="{{ asset('js/loader.js') }}"></script> 
    <script>
        
        // starts here
          function extractRegistrationCode() {
    const url = window.location.pathname; // Get the current URL path
    const match = url.match(/\/([A-Z]+\-\d+)/); // Use regex to match the pattern
    return match ? match[1] : null; // Return the matched code or null if no match
}
function extractRegistrationCode() {
    // Example: Assume registrationNumber is the last part of the current URL
    const pathSegments = window.location.pathname.split('/');
    return pathSegments[pathSegments.length - 1]; // Returns the last segment as registrationNumber
}
function handleMissingData() {
    window.location.href = '/error'; // Redirect to an error page
}


function goToWorkspace(event) {
    // Retrieve the specialization ID from the button's data attribute
    showLoadingIndicator('Opening Workstation...', 0);
    const specializationId = document.getElementById('specialization_id').value;

    const registrationNumber = extractRegistrationCode(); // Function to get registration number

    if (!registrationNumber || !specializationId) {
        alert('Error! Unable to access workspace. Please try again.');
        console.error('Missing specialization ID or registration number.');
        return;
    }

    try {
        updateLoadingProgress(70, 'Loading Workstation...');
        // Redirect to the appropriate workspace URL based on the specialization ID
        switch (specializationId) {
            case "9":
                window.location.href = `/psychotherapist/${registrationNumber}`;
                break;
            case "2":
                window.location.href = `/occupational_therapist/${registrationNumber}`;
                break;
            case "5":
                window.location.href = `/nutritionist/${registrationNumber}`;
                break;
            case "3":
                window.location.href = `/speech_therapist/${registrationNumber}`;
                break;
            case "4":
                window.location.href = `/physiotherapist/${registrationNumber}`;
                break;
            default:
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
            <input type="hidden" id="child_id" name="child_id" value="{{ $child_id }}">
            <input type="hidden" id="specialization_id" name="specialization_id" value="{{ $specialization_id }}">

            <label class="block text-sm font-medium text-gray-700" for="firstName"> Name</label>
            <input type="text" id="firstName" name="firstName" value="{{ $fullName}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="2018-02-28" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="gender">Gender/Age</label>
            <input type="text" id="genderAge" name="genderAge" value="{{ $gender }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="hnu">HNU</label>
            <input type="text" id="hnu" name="hnu" value="{{$child->id}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="mothersName">Mother's Name</label>
            <input type="text" id="mothersName" name="mothersName" value="{{$parents['femaleParent']['fullname'] ?? 'N/A'}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="motherTel">Tel</label>
            <input type="tel" id="motherTel" name="motherTel" value="{{$parents['femaleParent']['telephone'] ?? 'N/A'}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="motherEmail">Email</label>
            <input type="email" id="motherEmail" name="motherEmail"value="{{$parents['femaleParent']['email'] ?? 'N/A'}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="fathersName">Father's Name</label>
            <input type="text" id="fathersName" name="fathersName" value="{{$parents['maleParent']['fullname'] ?? 'N/A'}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="fatherTel">Tel</label>
            <input type="tel" id="fatherTel" name="fatherTel" value="{{$parents['maleParent']['telephone'] ?? 'N/A'}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700" for="fatherEmail">Email</label>
            <input type="email" id="fatherEmail" name="fatherEmail" value="{{$parents['maleParent']['email'] ?? 'N/A'}}" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
        </div>
    </div>

    

    <div class="bg-sky-50 p-6 rounded-lg space-y-2">
        <label class="block text-sm font-medium text-gray-700" for="date">Date</label>
        <input type="date" id="date" name="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
    </div>

    <div class="bg-sky-50 p-6 rounded-lg space-y-2">
        <label class="block text-sm font-medium text-gray-700" for="doctorsNotes">Therapy's Notes</label>
        <textarea id="doctorsNotes" name="doctorsNotes" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-h-[100px] resize-y" >{{$doctorsNotes}}</textarea>
    </div>

    <div class="bg-sky-50 p-6 rounded-lg space-y-2">
        <label class="block text-sm font-medium text-gray-700" for="createdBy">Created By</label>
        <input type="text" id="createdBy" name="createdBy" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
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
const menuLinks = floatingMenu.getElementsByTagName('a');

// Function to hide the menu links
function hideMenuLinks() {
    Array.from(menuLinks).forEach(link => {
        link.style.display = 'none';
    });
}

// Function to show the menu links
function showMenuLinks() {
    Array.from(menuLinks).forEach(link => {
        link.style.display = 'block';
    });
}

// Add a click event listener to the button to toggle the menu links
menuButton.addEventListener('click', (event) => {
    // Prevent the click event from propagating to the document
    event.stopPropagation(); 

    // Check if links are hidden
    const linksHidden = Array.from(menuLinks).some(link => 
        link.style.display === 'none' || link.style.display === '');

    if (linksHidden) {
        showMenuLinks();
    } else {
        hideMenuLinks();
    }
});

// Add a click event listener to the document to hide the menu links
document.addEventListener('click', (event) => {
    // Hide the menu links if the click is outside of the menu button or menu
    if (!menuButton.contains(event.target) && !floatingMenu.contains(event.target)) {
        hideMenuLinks();
    }
});

// Add a click event listener to the menu itself to prevent hiding when clicking inside
floatingMenu.addEventListener('click', (event) => {
    event.stopPropagation(); 
});

// Initially hide the menu links
hideMenuLinks();

// Add a click event listener to the document to hide the menu
document.addEventListener('click', (event) => {
  // Hide the menu if the click is outside of the menu button or menu
  if (!menuButton.contains(event.target) && !floatingMenu.contains(event.target)) {
    hideMenu();
  }
});

// Add a click event listener to the menu itself to prevent hiding when clicking inside
floatingMenu.addEventListener('click', (event) => {
  event.stopPropagation(); 
});
// Helper function to check and parse JSON responses
async function fetchAndParseJSON(url) {
    const response = await fetch(url);
    const contentType = response.headers.get('content-type');
    
    if (!contentType || !contentType.includes('application/json')) {
        throw new TypeError('Response was not JSON');
    }
    
    return response.json();
}

async function goToEncounterSummary() {
    event.preventDefault();
    console.log('EncounterSummary History link clicked.');

    const mainContent = document.querySelector('.main');

    // Enhanced CSS with modern design principles
    const style = document.createElement('style');
    style.innerHTML = `
        .loading-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
        }

        .spinner {
            border: 3px solid rgba(52, 152, 219, 0.1);
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .saving-button-spinner {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-top: 2px solid white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            vertical-align: middle;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            padding: 20px;
            background: #fdf0ef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin: 20px auto;
            max-width: 500px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .patient-info {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid #3498db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .patient-info:hover {
            transform: translateY(-2px);
        }

        .patient-info h3 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .patient-info p {
            margin: 0.5rem 0;
            color: #34495e;
        }

        .visits-container {
            margin-top: 2rem;
            display: grid;
            gap: 1.5rem;
        }

        .visit-entry {
            border: none;
            padding: 1.5rem;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .visit-entry:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .visit-entry h3 {
            margin: 0 0 1rem 0;
            color: #2c3e50;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .visit-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: #7f8c8d;
            font-size: 0.95rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #ecf0f1;
        }

        .notes {
            white-space: pre-wrap;
            margin-top: 1rem;
            padding: 1.25rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            color: #2c3e50;
            font-size: 0.95rem;
            line-height: 1.6;
            display: none; /* Initially hide the notes */
        }

        .section-title {
            color: #2c3e50;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
        }
    `;
    document.head.appendChild(style);

    // Show loading spinner
    mainContent.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
        </div>
    `;

    try {
        const registrationNumber = window.location.pathname.split('/').pop();
        console.log('Registration number extracted:', registrationNumber);
    
        // Use the new fetchAndParseJSON function
        const result = await fetchAndParseJSON(`/getDoctorNotes/${registrationNumber}`);
        console.log('Fetch response:', result);
    
        if (result.status === 'success') {
            mainContent.innerHTML = `
                <div class="container">
                    <h2 class="section-title">Encounter Summary History</h2>
                    
                    <div class="patient-info">
                        <h3>Patient Information</h3>
                        <p><strong>Registration Number:</strong> ${result.data.registration_number}</p>
                        <p><strong>Patient Name:</strong> ${result.data.child_name}</p>
                    </div>

                    <div class="visits-container">
                    
${result.data.visits.map(visit => `
    <div class="visit-entry">
        <h3>Visit Details</h3>
        <div class="visit-meta">
            <span><strong>Date:</strong> ${new Date(visit.visit_date).toLocaleDateString()}</span>
            <span><strong>Doctor:</strong> ${visit.doctor_first_name} ${visit.doctor_last_name} </span>
        </div>
        <div class="notes">
            <strong>Doctor's Notes:</strong><br>
            ${visit.notes || 'No notes recorded'}
        </div>
            <button 
                onclick="toggleDetails(this.parentElement)" 
                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition-colors duration-200">
                More Details
            </button>    </div>
`).join('')}
                    </div>
                </div>
            `;
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        mainContent.innerHTML = `
            <div class="container">
                <p class="error-message">
                    ${error instanceof TypeError ? 
                        'Server response format error. Please contact support.' : 
                        'Failed to load notes. Please try again later.'}
                </p>
            </div>
        `;
    }
}

function toggleDetails(element) {
    const notes = element.querySelector('.notes');
    notes.style.display = notes.style.display === 'none' ? 'block' : 'none';
}

    </script>
 <script>
    //to show name in side bar dynamically 
document.addEventListener("DOMContentLoaded", function() {
    const result = {
        data: {
            child_name: {!! json_encode($fullName) !!}
        }
    };
    document.getElementById("child-name-div").textContent = result.data.child_name;
});
</script>
    <script src="{{ asset('js/doctor.js') }}"></script>
    <script>
    //for Going to Dashboard loader
    function handleBackToDashboardClick() {
        showLoadingIndicator('Loading...',70);
        window.location.href = '/therapist_dashboard';
    }
</script>
<script>
function handleBackToPatientInfo() {
    const registrationNumber = extractRegistrationCode(); // Function to get registration number
    if (registrationNumber) {
        showLoadingIndicator('Opening Workstation...', 0);
        showLoadingIndicator('Loading...',70);
        window.location.href = `/occupationaltherapy_dashboard/${registrationNumber}`;
        
    } else {
        alert('Registration number not found.');
    }
}

function extractRegistrationCode() {
    const pathSegments = window.location.pathname.split('/');
    return pathSegments[pathSegments.length - 1]; // Returns the last segment as registrationNumber
}
</script>

</body>
</html>