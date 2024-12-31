<!DOCTYPE html>
<html>
<head>
<title>Doctor's Interface</title>
<style>
body {
  margin: 0;
  font-family: sans-serif;
}

.sidebar {
  height: 100%;
  width: 200px;
  position: fixed;
  left: 0;
  top: 0;
  background-color: #f1f1f1;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidebar a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 18px;
  color: #333;
  display: block;
}

.sidebar a:hover {
  background-color: #ddd;
}

.main {
  margin-left: 200px;
  padding: 20px;
}

.floating-menu {
  position: fixed;
  right: 20px;
  top: 40px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  padding: 5px;
}

.floating-menu a {
  display: block;
  padding: 6px;
  text-decoration: none;
  color: #333;
  border-bottom: 1px solid #ddd;
  position: relative; 
}

.floating-menu a:last-child {
  border-bottom: none;
}

.floating-menu a:hover {
  background-color: #f5f5f5;
}

#menuButton {
  position: fixed;
  right: 20px;
  top: 5px;
  background-color: #eee;
  border: none;
  padding: 10px;
  cursor: pointer;
}

.mini-menu {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  width: 150px;
  padding: 5px;
  list-style: none;
  margin: 50px;
  padding: 5px;
  right: 100%; 
  top: 150px;
  z-index: 10; 
}

.mini-menu li{
  border-bottom: 1px solid #ddd; 
}
.mini-menu li:last-child{
  border-bottom: none;
}

.mini-menu li a {
  display: block; 
  padding: 6px;
  text-decoration: none;
  color: #333;
  border-bottom: 1px solid #ddd; 
}

.mini-menu li:last-child a {
  border-bottom: none; 
}

.mini-menu li a:hover {
  background-color: #f5f5f5;
}
body {
  font-family: sans-serif;
}

.container {
  width: 800px; 
  margin: 0 auto;
  padding: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
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



.input-group {
  display: flex;
  gap: 5px; 
}

.input-group input[type="text"] {
  flex-grow: 1;
}

.highlighted {
  background-color: lightblue;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border: none;
  cursor: pointer;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="sidebar">
<h2>Active Patient: {{ $firstName }} {{ $middleName }} {{ $lastName }}</h2> 
  <a href="#">Logout</a>
  <a href="#">Multidsicplinary Communication</a>
  <a href="#">Therapy Summaries</a>
</div>

<div class="main">

<div class="container">

  <div class="input-group">
    <div>
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
      <input type="text" id="hnu" name="hnu"  value="{{ $child->registration_number }}">
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
      <label for="motherEmail">email:</label>
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
      <label for="fatherEmail">email:</label>
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
    <textarea id="doctorsNotes" name="doctorsNotes"></textarea>
  </div>

  <div class="highlighted">
    <label for="createdBy">Created By:</label>
    <input type="text" id="createdBy" name="createdBy">
  </div>

  <button type="submit">Save</button>
</div>
</div>

<div class="floating-menu" id="floatingMenu">
  <a href="#triageExam">Triage Exam</a><div id="triageExam"></div>
  <a href="#">Encounters Summary</a>
  <a href="#perinatalHistory">Perinatal History</a><div id="perinatalHistory"></div>
  <a href="#pastMedicalHistory">Past Medical History</a><div id="pastMedicalHistory"></div>
  <a href="#devMilestones">Developmental Milestones</a><div id="devMilestones"></div>
  <a href="#behaviourAssessment">Behaviour Assesement</a> <div id="behaviourAssessment"></div>
  <a href="#familyAndSocial">Family and Social History</a><div id="familyAndSocial"></div>
  <a href="#generalExam">General Examination</a><div id="generalExam"></div>
  <a href="#Examination">Examination</a><div id="Examination"></div>
  <a href="#devAssesment">Developmental Assesment</a><div id="devAssesment"></div>
  <a href="#diagnosis">Diagnoses</a><div id="diagnosis"></div>
  <a href="#investigations">Investigations</a><div id="investigations"></div>
  <a href="#recordResults">Record Results</a><div id="recordResults"></div>
  <a href="#carePlan">Plan of Action</a><div id="carePlan"></div>
  <a href="#">Immunization</a>
  <a href="#">Referral Letter</a>
  <a href="#">Patient Documents</a>
</div>

<button id="menuButton">Menu</button>

<script src="{{ asset('js/doctor.js') }}"></script>
<script>

const textareas = document.querySelectorAll('textarea');

textareas.forEach(textarea => {
  textarea.addEventListener('input', () => {
    textarea.style.height = "auto"; 
    textarea.style.height = (textarea.scrollHeight) + "px"; 
  });

  textarea.addEventListener('blur', () => {
    textarea.style.height = '30px'; // Reset height to original
  });

  // Initial adjustment
  textarea.style.height = "auto"; 
  textarea.style.height = (textarea.scrollHeight) + "px"; 
});
  </script>

</body>
</html>

