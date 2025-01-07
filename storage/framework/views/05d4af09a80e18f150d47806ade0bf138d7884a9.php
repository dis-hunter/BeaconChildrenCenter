<!DOCTYPE html>
<html>
<head>
  <title>Doctor's Interface</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }

    /* Sidebar Styles */
    .sidebar {
      height: 100%;
      width: 250px;
      position: fixed;
      left: 0;
      top: 0;
      background-color: lightblue;
      overflow-x: hidden;
      padding-top: 20px;
      transition: 0.3s;
      border-right: 3px solid #007bff;
    }

    .sidebar:hover {
      width: 300px;
    }

    .sidebar a {
      padding: 10px 8px 10px 16px;
      text-decoration: none;
      font-size: 20px;
      color: #333;
      display: block;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #e0f2f7;
      color: #007bff;
      padding-left: 25px;
    }

    .sidebar h2 {
      padding: 10px;
      color: #333;
      text-align: center;
    }

    .sidebar a i {
      margin-right: 10px;
    }

    /* Main Content Area */
    .main {
      margin-left: 250px;
      padding: 20px;
    }

    /* Floating Menu Styles */
    .floating-menu {
      position: fixed;
      right: 20px;
      top: 40px;
      background-color: lightblue; /* Light blue background */
      border: none;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Drop shadow effect */
    }

    .floating-menu a {
      display: block;
      padding: 8px 12px;
      text-decoration: none;
      color: #333; /* Dark gray text color */
      border-bottom: 1px solid #e0f2f7; /* Light blue separator */
      transition: 0.3s;
    }

    .floating-menu a:last-child {
      border-bottom: none;
    }

    .floating-menu a:hover {
      background-color: #e0f2f7; /* Lighter blue hover background */
      color: #007bff; /* Blue hover text color */
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
      padding: 10px;
      cursor: pointer;
      border-radius: 5px;
    }

    /* Form Container */
    .container {
      width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Labels */
    label {
      display: block;
      margin-bottom: 5px;
    }

    /* Input Fields and Textareas */
    input[type="text"],
    input[type="date"],
    textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      box-sizing: border-box;
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
      background-color: lightblue;
    }

    /* Buttons */
    button {
      background-color: #007bff;
      color: white;
      padding: 10px 15px;
      border: none;
      cursor: pointer;
    }
  </style>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>

<div class="sidebar">
  <h2><i class="fas fa-user-md"></i> Active Patient <br> <span style="color:blue;"><?php echo e($firstName); ?> <?php echo e($middleName); ?> <?php echo e($lastName); ?></span></h2> 
  <a href="#" id="homeLink"><i class="fas fa-home"></i> Home</a>
  <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
  <a href="#"><i class="fas fa-comments"></i> Multidisciplinary Communication</a>
  <a href="#"><i class="fas fa-file-medical"></i> Therapy Summaries</a>
</div>

<div class="main">
  <div class="container" id="mainContent">
    <!-- Form will be inserted here by JavaScript -->
  </div>
</div>

<div class="floating-menu" id="floatingMenu">
  <a href="#triageExam">Triage Exam</a><div id="triageExam"></div>
  <a href="#">Encounters Summary</a>
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
              <label for="firstName">First Name:</label>
              <input type="text" id="firstName" name="firstName" value="<?php echo e($firstName); ?>">
            </div>
            <div>
              <label for="middleName">Middle Name:</label>
              <input type="text" id="middleName" name="middleName" value="<?php echo e($middleName); ?>">
            </div>
            <div>
              <label for="lastName">Last Name:</label>
              <input type="text" id="lastName" name="lastName" value="<?php echo e($lastName); ?>">
            </div>
          </div>
          
          <div class="input-group">
            <div>
              <label for="dob">DOB:</label>
              <input type="date" id="dob" name="dob" value="<?php echo e($child->dob); ?>"> 
            </div>
            <div>
              <label for="genderAge">Gender/Age:</label>
              <input type="text" id="genderAge" name="genderAge" value="<?php echo e($gender); ?>">
            </div>
            <div>
              <label for="hnu">HNU:</label>
              <input type="text" id="hnu" name="hnu" value="<?php echo e($child->registration_number); ?>">
            </div>
          </div>

          <div class="input-group">
            <div>
              <label for="mothersName">Mother's Name:</label>
              <input type="text" id="mothersName" name="mothersName">
            </div>
            <div>
              <label for="motherTel">Tel:</label>
              <input type="text" id="motherTel" name="motherTel">
            </div>
            <div>
              <label for="motherEmail">Email:</label>
              <input type="text" id="motherEmail" name="motherEmail">
            </div>
          </div>

          <div class="input-group">
            <div>
              <label for="fathersName">Father's Name:</label>
              <input type="text" id="fathersName" name="fathersName">
            </div>
            <div>
              <label for="fatherTel">Tel:</label>
              <input type="text" id="fatherTel" name="fatherTel">
            </div>
            <div>
              <label for="fatherEmail">Email:</label>
              <input type="text" id="fatherEmail" name="fatherEmail">
            </div>
          </div>

          <label for="informant">Informant:</label>
          <input type="text" id="informant" name="informant">

          <div class="highlighted">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date"> 
          </div>

         <div class="highlighted">
    <label for="doctorsNotes">Doctor's Notes:</label>
   <textarea id="doctorsNotes" name="doctorsNotes" rows="10" cols="50"><?php echo e($doctorsNotes); ?></textarea>
</div>


          <div class="highlighted">
            <label for="createdBy">Created By:</label>
            <input type="text" id="createdBy" name="createdBy">
          </div>

          <button type="submit">Save</button>
        </form> 
      </div>
    `;
    }

    // Event listener for Home link
    const homeLink = document.getElementById('homeLink');
    if (homeLink) {
      homeLink.addEventListener('click', showHomeForm);
    }

    // Call showHomeForm() to display the form initially
    showHomeForm();
  });
</script>
<script src="<?php echo e(asset('js/doctor.js')); ?>"></script>
<script src="<?php echo e(asset('js/Referral.js')); ?>"></script>
<script src="<?php echo e(asset('js/careplan.js')); ?>"></script>
<script src="<?php echo e(asset('js/developmentalAssesment.js')); ?>"></script>
<script src="<?php echo e(asset('js/examination.js')); ?>"></script>
<script src="<?php echo e(asset('js/pastMedicalHistory.js')); ?>"></script>
<script src="<?php echo e(asset('js/familyAndSocial.js')); ?>"></script>
<script src="<?php echo e(asset('js/developmentalMilestones.js')); ?>"></script>
<script src="<?php echo e(asset('js/perinatalHistory.js')); ?>"></script>
<script src="<?php echo e(asset('js/behaviourAssesment.js')); ?>"></script>
<script src="<?php echo e(asset('js/generalExam.js')); ?>"></script>
<script src="<?php echo e(asset('js/diagnosis.js')); ?>"></script>
<script src="<?php echo e(asset('js/triageresults.js')); ?>"></script>
<script src="<?php echo e(asset('js/investigations.js')); ?>"></script>
<script src="<?php echo e(asset('js/recordResults.js')); ?>"></script>
<script src="<?php echo e(asset('js/prescriptions.js')); ?>"></script>

</body>
</html>
<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/doctor.blade.php ENDPATH**/ ?>