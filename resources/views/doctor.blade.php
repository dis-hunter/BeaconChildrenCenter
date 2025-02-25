<!DOCTYPE html>
<html>
<head>
  <title>Doctor's Interface</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
  margin: 0;
  font-family: sans-serif;
  background-color: #f4f4f9; /* Light background for contrast */
}

/* Sidebar Styles */
.sidebar {
  height: 100%;
  width: 250px;
  position: fixed;
  left: 0;
  top: 0;
  background-color: #007bff;
  overflow-x: hidden;
  padding-top: 20px;
  transition: 0.3s;
  border-right: 3px solid lightblue; /* Add border to the right side */
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
}



.sidebar a {
  padding: 12px 16px;
  margin: 10px 0; /* Adds spacing between links */
  text-decoration: none;
  font-size: 18px; /* Reduced font size */
  color: white;
  display: block;
  transition: 0.3s;
  border-radius: 5px; /* Rounded corners */
}

.sidebar a:hover {
  background-color: white; /* Theme color on hover */
  color: black;
  padding-left: 25px;
  transform: translateX(5px); /* Subtle slide effect */
}

.sidebar h2 {
  padding: 10px;
  color: #333;
  text-align: center;
  font-size: 24px;
  animation: fadeIn 1s ease-in-out; /* Fade-in animation */
}

.sidebar a i {
  margin-right: 10px;
}

/* Main Content Area */
.main {
  margin-left: 250px;
  padding: 20px;
  transition: 0.3s;
}

/* Floating Menu Styles */
.floating-menu {
  position: fixed;
  right: 20px;
  top: 40px;
  background-color: #007bff;
  border: none;
  padding: 10px;
  border-radius: 10px; /* More rounded corners */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Deeper shadow */
  max-height: 550px;
  overflow-y: auto;
  transition: 0.3s;
}

.floating-menu:hover {
  transform: scale(1.05); /* Slight zoom on hover */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
}

.floating-menu a {
  display: block;
  padding: 8px 12px;
  text-decoration: none;
  color: white;
  border-bottom: 1px solid #e0f2f7;
  transition: 0.3s;
  border-radius: 5px; /* Rounded corners */
}

.floating-menu a:last-child {
  border-bottom: none;
}

.floating-menu a:hover {
  background-color: #007bff; /* Theme color on hover */
  color: white;
  padding-left: 20px;
}

/* Menu Button */
#menuButton {
  position: fixed;
  right: 20px;
  top: 5px;
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 5px;
  transition: 0.3s;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow for depth */
}

#menuButton:hover {
  background-color: #005bb5; /* Darker blue on hover */
  transform: translateY(-2px); /* Slight lift on hover */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
}

/* Form Container */
.container {
  width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Shadow for depth */
  
}

/* Labels */
label {
  display: block;
  margin-bottom: 5px;
  color: #007bff; /* Theme color for labels */
  font-weight: bold;
}

/* Input Fields and Textareas */
input[type="text"],
input[type="date"],
textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  transition: 0.3s;
}

input[type="text"]:focus,
input[type="date"]:focus,
textarea:focus {
  border-color: #007bff; /* Theme color on focus */
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.3); /* Glow effect on focus */
}

textarea#doctorsNotes {
  height: 30px;
  resize: vertical;
}

/* Input Groups */
.input-group {
  display: flex;
  gap: 5px;
}

.input-group input[type="text"] {
  flex-grow: 1;
}

/* Highlighted Sections */
.highlighted {
  background-color:  #007bff;
  color:white;
  padding: 10px;
  border-radius: 5px;
   /* Pulse animation */
}

/* Buttons */
button {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: 0.3s;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow for depth */
}

button:hover {
  background-color: #005bb5; /* Darker blue on hover */
  transform: translateY(-2px); /* Slight lift on hover */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideIn {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="sidebar">


  <p style="margin-left:18px;"><span style="color:white; font-size:19px;">Active Patient:<br>{{ $firstName }} {{ $middleName }} {{ $lastName }}</span></p> 
  <a href="#" id="homeLink"><i class="fas fa-home"></i> Home</a>
  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
  </form>
  <a href="/doctorDashboard"><i class="fas fa-tachometer-alt"></i> Return to Dashboard</a>
</div>

<div class="main">
  <div class="container" id="mainContent">
    <!-- Form will be inserted here by JavaScript -->
  </div>
</div>

<div class="floating-menu" id="floatingMenu">
  <a href="#triageExam">Triage Exam</a><div id="triageExam"></div>
  <a href="#EncounterSummary">Encounters Summary</a>
  <a href="#perinatalHistory">Perinatal History</a><div id="perinatalHistory"></div>
  <a href="#pastMedicalHistory">Past Medical History</a><div id="pastMedicalHistory"></div>
  <a href="#devMilestones">Developmental Milestones</a><div id="devMilestones"></div>
  <a href="#behaviourAssessment">Behaviour Assessment</a> <div id="behaviourAssessment"></div>
  <a href="#familyAndSocial">Family and Social History</a><div id="familyAndSocial"></div>
  <a href="#generalExam">General Examination</a><div id="generalExam"></div>
  <a href="#Examination">Examination</a><div id="Examination"></div>
  <a href="#devAssesment">Developmental Assessment</a><div id="devAssesment"></div>
  <a href="#diagnosis">Diagnoses</a><div id="diagnosis"></div>
  <a href="#investigations">Investigations</a><div id="investigations"></div>
  <a href="#recordResults">Record Results</a><div id="recordResults"></div>
  <a href="#carePlan">Plan of Action</a><div id="carePlan"></div>
  <a href="#prescriptions">Prescriptions</a><div id="prescriptions"></div>
  <a href="#referral">Referral Letter</a><div id="referral"></div>
  <a href="#">Patient Documents</a>
</div>

<button id="menuButton">Menu</button>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Function to clear the main content area and display the form (Home button functionality)
    function showHomeForm() {
      const mainContent = document.querySelector('.main');
    mainContent.innerHTML = `
      <div class="container">
        <form id="patient-form">
          <div class="input-group">
            <div>
            <input type="hidden" id="child_id" name="child_id" value="{{ $child_id }}">
              <label for="firstName">First Name:</label>
              <input type="text" id="firstName" name="firstName" value="{{ $firstName }}">
            </div>
            <div>
              <label for="middleName">Middle Name:</label>
              <input type="text" id="middleName" name="middleName" value="{{ $middleName }}">
            </div>
            <div>
              <label for="lastName">Last Name:</label>
              <input type="text" id="lastName" name="lastName" value="{{ $lastName }}">
            </div>
          </div>
          
          <div class="input-group">
            <div>
              <label for="dob">DOB:</label>
              <input type="date" id="dob" name="dob" value="{{ $child->dob }}"> 
            </div>
            <div>
              <label for="genderAge">Gender/Age:</label>
              <input type="text" id="genderAge" name="genderAge" value="{{ $gender }}">
            </div>
            <div>
              <label for="hnu">HNU:</label>
              <input type="text" id="hnu" name="hnu" value="{{ $child->registration_number }}">
            </div>
          </div>

          <div class="input-group">
    <div>
      <label for="mothersName">Mother's Name:</label>
      <input type="text" id="mothersName" name="mothersName" value="{{ $parents['Mother']['fullname'] ?? '' }}"> 
    </div>
    <div>
      <label for="motherTel">Tel:</label>
      <input type="text" id="motherTel" name="motherTel" value="{{ $parents['Mother']['telephone'] ?? '' }}"> 
    </div>
    <div>
      <label for="motherEmail">Email:</label>
      <input type="text" id="motherEmail" name="motherEmail" value="{{ $parents['Mother']['email'] ?? '' }}"> 
    </div>
  </div>

          <div class="input-group">
    <div>
      <label for="fathersName">Father's Name:</label>
      <input type="text" id="fathersName" name="fathersName" value="{{ $parents['Father']['fullname'] ?? '' }}"> 
    </div>
    <div>
      <label for="fatherTel">Tel:</label>
      <input type="text" id="fatherTel" name="fatherTel" value="{{ $parents['Father']['telephone'] ?? '' }}"> 
    </div>
    <div>
      <label for="fatherEmail">Email:</label>
      <input type="text" id="fatherEmail" name="fatherEmail" value="{{ $parents['Father']['email'] ?? '' }}"> 
    </div>
  </div>

          <label for="informant">Informant:</label>
          <input type="text" id="informant" name="informant">

          <div class="highlighted">
            <label style="color:white;" for="date">Date:</label>
            <input type="date" id="date" name="date"> 
          </div>

         <div class="highlighted">
    <label style="color:white;" for="doctorsNotes">Doctor's Notes:</label>
   <textarea id="doctorsNotes" name="doctorsNotes" rows="10" cols="50">{{ $doctorsNotes }}</textarea>
</div>


          <div class="highlighted">
            <label style="color:white;" for="createdBy">Created By:</label>
            <input type="text" id="createdBy" name="createdBy">
          </div>

<button id="saveButton" type="button">Save</button>
        </form> 
      </div>
    `;
    const saveButton = document.getElementById("saveButton");
      saveButton.addEventListener("click", function(event) {
          event.preventDefault();
          saveDoctorNotes();
      });
    }

    const homeLink = document.getElementById('homeLink');
    if (homeLink) {
      homeLink.addEventListener('click', showHomeForm);
    }

    showHomeForm();
});
async function saveDoctorNotes() {
    try {
        const doctorNotes = document.getElementById("doctorsNotes").value;
        const childId = document.getElementById('child_id').value;

        const dataToSend = {
            child_id: childId,
            notes: doctorNotes
        };

        const response = await fetch('/saveDoctorNotes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(dataToSend)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        if (result.status === 'success') {
            alert('Notes saved successfully!');
        } else {
            alert('Failed to save notes. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error saving notes');
    }
}



        
</script>
<script src="{{ asset('js/doctor.js') }}"></script>
<script src="{{ asset('js/Referral.js') }}"></script>
<script src="{{ asset('js/careplan.js') }}"></script>
<script src="{{ asset('js/developmentalAssesment.js') }}"></script>
<script src="{{ asset('js/examination.js') }}"></script>
<script src="{{ asset('js/pastMedicalHistory.js') }}"></script>
<script src="{{ asset('js/familyAndSocial.js') }}"></script>
<script src="{{ asset('js/developmentalMilestones.js') }}"></script>
<script src="{{ asset('js/perinatalHistory.js') }}"></script>
<script src="{{ asset('js/behaviourAssesment.js') }}"></script>
<script src="{{ asset('js/generalExam.js') }}"></script>
<script src="{{ asset('js/diagnosis.js') }}"></script>
<script src="{{ asset('js/triageresults.js') }}"></script>
<script src="{{ asset('js/investigations.js') }}"></script>
<script src="{{ asset('js/recordResults.js') }}"></script>
<script src="{{ asset('js/EncounterSummary.js') }}"></script>
<script src="{{ asset('js/prescriptions.js') }}"></script>


</body>
</html>
