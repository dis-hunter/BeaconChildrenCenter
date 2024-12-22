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
</style>
</head>
<body>

<div class="sidebar">
  <a href="#">Active Patients</a>
  <a href="#">Logout</a>
  <a href="#">User</a>
  <a href="#">Dr Emmanuel</a>
</div>

<div class="main">
  <h2>Main Content</h2>
  <p>Some text for the main content area.</p>
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
  <a href="#" id="pastInvestigationsLink">Past Investigations</a>
  <ul class="mini-menu" id="pastInvestigationsMenu">
    <li><a href="#">Labaratort Tests</a></li>
    <li><a href="#">Imaging</a></li>
    <li><a href="#">Electro <br> phsiologic tests</a></li>
    <li><a href="#">Genetic tests</a></li>
    <li><a href="#">Other tests</a></li>
  </ul>
  <a href="#" id="recordResultsLink">Record Results</a>
  <ul class="mini-menu" id="recordResultsMenu">
    <li><a href="#">Labaratort Tests</a></li>
    <li><a href="#">Imaging</a></li>
    <li><a href="#">Electro <br> phsiologic tests</a></li>
    <li><a href="#">Genetic tests</a></li>
    <li><a href="#">Other tests</a></li>
  </ul>
  <a href="#carePlan">Plan of Action</a><div id="carePlan"></div>
  <a href="#">Immunization</a>
  <a href="#">Referral Letter</a>
  <a href="#">Patient Documents</a>
</div>

<button id="menuButton">Menu</button>

<script src="{{ asset('js/doctor.js') }}"></script>

</body>
</html>